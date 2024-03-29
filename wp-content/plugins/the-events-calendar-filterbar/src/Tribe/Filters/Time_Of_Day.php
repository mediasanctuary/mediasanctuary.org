<?php

/**
 * Class Tribe__Events__Filterbar__Filters__Time_Of_Day
 */
class Tribe__Events__Filterbar__Filters__Time_Of_Day extends Tribe__Events__Filterbar__Filter {
	public $type = 'checkbox';

	// These are needed to make the join aliases unique
	protected $alias = '';
	protected $alias_prefix = 'all_day_';
	protected $tod_start_alias = '';
	protected $tod_duration_alias = '';

	protected function get_values() {
		// The time-of-day filter.
		$time_of_day_array = array(
			'allday' => __( 'All Day', 'tribe-events-filter-view' ),
			'06-12' => __( 'Morning', 'tribe-events-filter-view' ),
			'12-17' => __( 'Afternoon', 'tribe-events-filter-view' ),
			'17-21' => __( 'Evening', 'tribe-events-filter-view' ),
			'21-06' => __( 'Night', 'tribe-events-filter-view' ),
		);

		$time_of_day_values = array();
		foreach ( $time_of_day_array as $value => $name ) {
			$time_of_day_values[] = array(
				'name' => $name,
				'value' => $value,
			);
		}
		return $time_of_day_values;
	}

	/**
	 * Returns the alias prefix - for use in custom tables
	 *
	 * @since 5.4.0
	 *
	 * @return string The table alias prefix
	 */
	public function get_all_day_table_alias_prefix() {
		return $this->alias_prefix;
	}

	/**
	 * Returns the current table alias for Time of Day start.
	 *
	 * @since 5.4.0
	 *
	 * @return string
	 */
	public function get_tod_start_alias() {
		return $this->tod_start_alias;
	}

	/**
	 * Returns the current table alias for Time of Day duration.
	 *
	 * @since 5.4.0
	 *
	 * @return string
	 */
	public function get_tod_duration_alias() {
		return $this->tod_duration_alias;
	}

	protected function setup_join_clause() {
		global $wpdb;
		$values = $this->currentValue;

		// They've checked _everything_, let's not pile on the JOINs.
		if ( empty( $values ) || count( $values ) === count( $this->get_values() ) ) {
			return;
		}

		$all_day_index = array_search( 'allday', $values );

		if ( $all_day_index !== false ) {
			unset( $values[ $all_day_index ] );
		}

		$this->alias = $this->alias_prefix . uniqid();
		$this->tod_start_alias = 'tod_start_date_' . uniqid();
		$this->tod_duration_alias = 'tod_duration_' . uniqid();

		$joinType = empty( $all_day_index ) ? 'LEFT' : 'INNER';

		$this->joinClause .= " {$joinType} JOIN {$wpdb->postmeta} AS {$this->alias} ON ({$wpdb->posts}.ID = {$this->alias}.post_id AND {$this->alias}.meta_key = '_EventAllDay')";

		if ( ! empty( $values ) ) { // values other than allday
			$this->joinClause .= " INNER JOIN {$wpdb->postmeta} AS {$this->tod_start_alias} ON ({$wpdb->posts}.ID = {$this->tod_start_alias}.post_id AND {$this->tod_start_alias}.meta_key = '_EventStartDate')";
			$this->joinClause .= " INNER JOIN {$wpdb->postmeta} AS {$this->tod_duration_alias} ON ({$wpdb->posts}.ID = {$this->tod_duration_alias}.post_id AND {$this->tod_duration_alias}.meta_key = '_EventDuration')";
		}
	}

	protected function setup_where_clause() {
		global $wpdb;
		$clauses = [];
		$values = $this->currentValue;

		// They've checked _everything_, let's not pile on the JOINs.
		if ( empty( $values ) || count( $values ) === count( $this->get_values() ) ) {
			return;
		}

		foreach ( $values as $time_range_string ) {
			if ( $time_range_string == 'allday' ) {
				continue; // handled later.
			}

			$time_range_frags = explode( '-', $time_range_string );
			$range_start_hour = $time_range_frags[0];
			$range_end_hour   = $time_range_frags[1];
			$range_start_time = $time_range_frags[0] . ':00:00';
			$range_end_time   = $time_range_frags[1] . ':00:00';

			$is_overnight_range = $range_start_hour > $range_end_hour;
			if ( $is_overnight_range ) {
				$clauses[] = $wpdb->prepare(
					"(
						( TIME(CAST({$this->tod_start_alias}.meta_value as DATETIME)) < %s )
						OR ( TIME(CAST({$this->tod_start_alias}.meta_value as DATETIME)) >= %s )
						OR ( MOD(TIME_TO_SEC(TIMEDIFF(%s, TIME(CAST({$this->tod_start_alias}.meta_value as DATETIME)))) + 86400, 86400) < {$this->tod_duration_alias}.meta_value )
					)",
					$range_end_time,
					$range_start_time,
					$range_end_time
				);
			} else {
				$clauses[] = $wpdb->prepare(
					"(
						( TIME(CAST({$this->tod_start_alias}.meta_value as DATETIME)) >= %s AND TIME(CAST({$this->tod_start_alias}.meta_value as DATETIME)) < %s )
						OR ( MOD(TIME_TO_SEC(TIMEDIFF(%s, TIME(CAST({$this->tod_start_alias}.meta_value as DATETIME)))) + 86400, 86400) < {$this->tod_duration_alias}.meta_value )
					)",
					$range_start_time,
					$range_end_time,
					$range_start_time
				);
			}
		}

		if ( in_array( 'allday', $values ) ) {
			$clauses[] = "( {$this->alias}.meta_value = 'yes' OR {$this->alias}.meta_value = '1' )";
		} else {
			$this->whereClause .= " AND ( {$this->alias}.meta_id IS NULL OR {$this->alias}.meta_value != 'yes' OR {$this->alias}.meta_value != '1' ) ";
		}

		$this->whereClause .= ' AND (' . implode( ' OR ', $clauses ) . ')';
	}
}
