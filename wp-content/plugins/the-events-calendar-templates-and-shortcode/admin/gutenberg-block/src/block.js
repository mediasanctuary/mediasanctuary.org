/**
 * Block dependencies
 */


import EctIcon from './icons';
import LayoutType from './layout-type';

const baseURL=ectUrl;
const LayoutImgPath=baseURL+'assets/images/';
/**
 * Internal block libraries
 */
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { apiFetch } = wp;
const {
	RichText,
	InspectorControls,
	BlockControls,
} = wp.blockEditor;
const {
	registerStore,
	withSelect,
} = wp.data;
const { 
	TabPanel,
	Panel,
	PanelBody,
	PanelRow,
	ButtonGroup,
	Text,
    TextareaControl,
	TextControl,
	Dashicon,
	Button,
	SelectControl,
	RangeControl,
	Card,
} = wp.components;
const catgorySelections = [];
let categoryList = [];
let tagList=[];
let venueList=[];
let organizerList=[];
wp.apiFetch({path:'/tribe/events/v1/categories/?per_page=50'}).then(data => {
 if(typeof(data.categories)!=undefined){
	categoryList=data.categories.map(function(val,key){
		return {label: val.name, value: val.slug};
	});
	}
	categoryList.push({label: "Select a Category", value:'all'});
});
wp.apiFetch({path:'/tribe/events/v1/tags/?per_page=50'}).then(data => {
	if(typeof(data.tags)!=undefined){
		tagList=data.tags.map(function(val,key ) {
 		 return {label: val.name, value: val.slug};
  		 });
	}
	tagList.push({label: "Select a Tag", value:''}); 
});
wp.apiFetch({path:'/tribe/events/v1/venues/?per_page=50&status=publish'}).then(data => {
	if(data.venues!=undefined){
		venueList=data.venues.map(function(val,key) {
  		 return {label: val.venue, value: val.id};
  		 }); 
	}
	venueList.push({label: "Select a Venue", value:''});
   });
 wp.apiFetch({path:'/tribe/events/v1/organizers/?per_page=50&status=publish'}).then(data => {
	if(data.organizers!=undefined){
		organizerList=data.organizers.map(function( val,key) {
	   return {label: val.organizer, value: val.id};
  		 });
	} 
	organizerList.push({label: "Select a Organizer", value:''});
   });
  /**
 * Register block
 */
export default registerBlockType( 'ect/shortcode', {
		// Block Title
		title: __( 'Events Shortcodes' ),
		// Block Description
		description: __( 'The Events Calendar - Shortcode & Templates Pro Addon' ),
		// Block Category
		category: 'common',
		// Block Icon
		icon: EctIcon,
		// Block Keywords
		keywords: [
			__( 'the events calendar' ),
			__( 'templates' ),
			__( 'cool plugins' )
		],
	attributes: {
		template: {
			type: 'string',
			default: 'default'
		},
		category: {
			type: 'string',
			default: 'all'
		},
		style: {
			type: 'string',
			default: 'style-1'
		},
		order: {
			type: 'string',
			default: 'ASC'
		},
		based: {
			type: 'string',
			default: 'default'
		},
		storycontent: {
			type: 'string',
			default: 'default'
		},
		limit: {
            type: 'string',
            default: '10'
        },
		dateformat: {
			type: 'string',
			default:  'default',
		},
		startDate: {
            type: 'string',
            default: ''
		},
		endDate: {
            type: 'string',
            default: ''
        },
		hideVenue: {
			type: 'string',
			default:  'no',
		},
		time: {
			type: 'string',
			default:  'future',
		},
		featuredonly: {
			type: 'string',
			default:  'false',
		},
		showdescription:{
			type: 'string',
			default:  'yes',
		},
		columns: {
			type: 'string',
			default:2,
		},
		autoplay: {
			type: 'string',
			default:  'true',
		},
		tags: {
			type: 'string',
			default: ''
		},
		venues: {
			type: 'string',
			default: ''
		},
		organizers: {
			type: 'string',
			default: ''
		},
		socialshare: {
			type: 'string',
			default: 'no'
		},
		datetxt: {
            type: 'string',
            default: 'Date'
		},
		timetxt: {
            type: 'string',
            default: 'Duration'
		},
		desctxt:{
			type: 'string',
            default: 'Description'
		},
		evttitle: {
            type: 'string',
            default: 'Event Name'
		},
		eventVenueTittle: {
            type: 'string',
            default: 'Location'
		},
		viewMoreTittle:{
			type: 'string',
            default: 'View More'
		},
		cateTitle:{
			type: 'string',
            default: 'Category'
		}
		
	},
	// Defining the edit interface
	edit: props => {
		const layoutOptions = [
			{label: 'Default List Layout', value: 'default'},
			{label: 'Timeline Layout', value: 'timeline-view'},
			{label: 'Slider Layout', value: 'slider-view'},
			{label:'Carousel Layout',value:'carousel-view'},
			{label:'Grid Layout',value:'grid-view'},
			{label:'Masonry Layout(Categories Filters)',value:'masonry-view'},
			{label:'Toggle List Layout',value:'accordion-view'},
			{label: 'Minimal List', value: 'minimal-list'},
			{label: 'Advance List', value: 'advance-list'}
		];
		const colContains=[
			"carousel-view",
			"grid-view",
			"masonry-view",
		];
		const autoplayContains=[
			"carousel-view",
			"slider-view",
			"cover-view",
		];
		const dateFormatsOptions = [
			{label:"Default (01 January 2019)",value:"default"},
			{label:"Md,Y (Jan 01, 2019)",value:"MD,Y"},
			{label:"Fd,Y (January 01, 2019)",value:"MD,Y"},
			{label:"dM (01 Jan)",value:"DM"},
			{label:"dF (01 January)",value:"DF"},
			{label:"Md (Jan 01)",value:"MD"},
			{label:"Fd (January 01)",value:"FD"},
			{label:"Md,YT (Jan 01, 2019 8:00am-5:00pm)",value:"MD,YT"},
			{label:"Full (01 January 2019 8:00am-5:00pm)",value:"full"},
			{label:"jMl (1 Jan Monday)",value:"jMl"},
			{label:"d.FY (01. January 2019)",value:"d.FY"},
			{label:"d.F (01. January)",value:"d.F"},
			{label:"d.Ml (01. Jan Monday)",value:"d.Ml"},
			{label:"ldF (Monday 01 January)",value:"ldF"},
			{label:"Mdl (Jan 01 Monday)",value:"Mdl"},
			{label:"dFT (01 January 8:00am-5:00pm)",value:"dFT"},
	//		{label:"Custom(Using The Events Calendar settings)",value:"custom"},
		 ];
		const columnsOptions=[
			{label:'2',value:'2'},
			{label:'3',value:'3'},
			{label:'4',value:'4'},
			{label:'6',value:'6'},
		];
		return [
			!! props.isSelected && (
				<InspectorControls key="inspector">
				<TabPanel
                    className="ect-tab-settings"
                    activeClass="active-tab"
                    tabs={ [
                        {
                            name: 'ect_general_setting',
                            title: 'Layout',
                            className: 'tab-one',
                            content: <><PanelBody>
							<SelectControl
								label={ __( 'Select Template' ) }
								options={ layoutOptions }
								value={ props.attributes.template }
								onChange={ ( value ) =>props.setAttributes( { template: value } ) }
								/>
							{props.attributes.template!=='advance-list'&&
								<>
								<div className="ect_shortcode-button-group_label">{__("Select Style")}</div>
								<ButtonGroup className="ect_shortcode-button-group">
									<Button onClick={(e) => {props.setAttributes({style: 'style-1'})}} className={props.attributes.style == 'style-1' ? 'active': ''} isSmall={true}>Style 1</Button>
									<Button onClick={(e) => {props.setAttributes({style: 'style-2'})}} className={props.attributes.style == 'style-2' ? 'active': ''} isSmall={true}>Style 2</Button>
									<Button onClick={(e) => {props.setAttributes({style: 'style-3'})}} className={props.attributes.style == 'style-3' ? 'active': ''} isSmall={true}>Style 3</Button>
								</ButtonGroup>
								</>
							}
							
							
							<SelectControl
							label={ __( 'Date Formats' ) }
							description={ __( 'yes/no' ) }
							options={ dateFormatsOptions }
							value={ props.attributes.dateformat }
							onChange={ ( value ) =>props.setAttributes( { dateformat: value } ) }
							/>	
							<RangeControl
                        label="Limit the events"
                        value={ parseInt(props.attributes.limit) }
                        onChange={ ( value ) => props.setAttributes( { limit: value.toString() } ) }
                        min={ 1 }
                        max={ 100 }
                        step={ 1 }
                    />
							{colContains.includes(props.attributes.template)&&
							<SelectControl
								label={ __( 'Columns' ) }
								description={ __( 'Columns' ) }
								options={ columnsOptions }
								value={ props.attributes.columns }
								onChange={ ( value ) =>props.setAttributes( { columns: value } ) }
								/>
							}{autoplayContains.includes(props.attributes.template)&&
								<>
								<div className="ect_shortcode-button-group_label">{__("AutoPlay")}</div>
								<ButtonGroup className="ect_shortcode-button-group">
                    				<Button onClick={(e) => {props.setAttributes({autoplay: 'false'})}} className={props.attributes.autoplay == 'false' ? 'active': ''} isSmall={true}>False</Button>
                    				<Button onClick={(e) => {props.setAttributes({autoplay: 'true'})}} className={props.attributes.autoplay == 'true' ? 'active': ''} isSmall={true}>True</Button>
                    			</ButtonGroup>
								</>
							}
						
						
								</PanelBody>
								<Panel>
							<PanelBody title="Extra Settings" initialOpen={ false }>
            				<PanelRow>
								
								<ButtonGroup className="ect_shortcode-button-group">
								<div className="ect_shortcode-button-group_label">{__("Hide Venue")}</div>
								<div>

								
                    			<Button onClick={(e) => {props.setAttributes({hideVenue: 'no'})}} className={props.attributes.hideVenue == 'no' ? 'active': ''} isSmall={true}>No</Button>
                    			<Button onClick={(e) => {props.setAttributes({hideVenue: 'yes'})}} className={props.attributes.hideVenue == 'yes' ? 'active': ''} isSmall={true}>Yes</Button>
                    			</div>
								</ButtonGroup>
							</PanelRow>
							<PanelRow>
							
								<ButtonGroup className="ect_shortcode-button-group">
								<div className="ect_shortcode-button-group_label">{__("Show Description?")}</div>
								<div>
                    			<Button onClick={(e) => {props.setAttributes({showdescription: 'no'})}} className={props.attributes.showdescription == 'no' ? 'active': ''} isSmall={true}>No</Button>
                    			<Button onClick={(e) => {props.setAttributes({showdescription: 'yes'})}} className={props.attributes.showdescription == 'yes' ? 'active': ''} isSmall={true}>Yes</Button>
                    			</div>
								</ButtonGroup>
							</PanelRow>
							{props.attributes.template!='advance-list'&&	
							<PanelRow>
							
							<ButtonGroup className="ect_shortcode-button-group">
							<div className="ect_shortcode-button-group_label">{__("Enable Social Share Buttons?")}</div>
							<div>
						<Button onClick={(e) => {props.setAttributes({socialshare: 'no'})}} className={props.attributes.socialshare == 'no' ? 'active': ''} isSmall={true}>No</Button>
						<Button onClick={(e) => {props.setAttributes({socialshare: 'yes'})}} className={props.attributes.socialshare == 'yes' ? 'active': ''} isSmall={true}>Yes</Button>
						</div>
						</ButtonGroup>
								</PanelRow>
						}
        					</PanelBody>
							
						</Panel>
							{props.attributes.template=='advance-list'&&	
					<Panel>
							<PanelBody title="Dynamic Label" initialOpen={ false }>
            				<PanelRow>
							<TextControl
								label={ __( 'Date Heading Label' ) }
								value={ props.attributes.datetxt }
								onChange={ ( value ) =>props.setAttributes( { datetxt: value } ) }
							/>	
							</PanelRow>
							<PanelRow>
							<TextControl
								label={ __( 'Duration Heading Label' ) }
								value={ props.attributes.timetxt }
								onChange={ ( value ) =>props.setAttributes( { timetxt: value } ) }
							/>
							</PanelRow>
							<PanelRow>
							<TextControl
								label={ __( 'Find Out More Heading Label' ) }
								value={ props.attributes.viewMoreTittle }
								onChange={ ( value ) =>props.setAttributes( { viewMoreTittle: value } ) }
							/>
							</PanelRow>
							
							<PanelRow>
							<TextControl
							label={ __( 'Title Heading Label' ) }
								value={ props.attributes.evttitle }
								onChange={ ( value ) =>props.setAttributes( { evttitle: value } ) }
							/>	
							</PanelRow>
							<PanelRow>
							<TextControl
								label={ __( 'Description Heading Label' ) }
								value={ props.attributes.desctxt }
								onChange={ ( value ) =>props.setAttributes( { desctxt: value } ) }
							/>
							</PanelRow>
							<PanelRow>
							<TextControl
								label={ __( 'Venue Heading Label' ) }
								value={ props.attributes.eventVenueTittle }
								onChange={ ( value ) =>props.setAttributes( { eventVenueTittle: value } ) }
							/>
							</PanelRow>
							<PanelRow>
							<TextControl
								label={ __( 'Category Heading Label' ) }
								value={ props.attributes.cateTitle }
								onChange={ ( value ) =>props.setAttributes( { cateTitle: value } ) }
							/>
							</PanelRow>
							</PanelBody>
						
							
							
							</Panel>
						}
    					
								</>
                        },
						{
                            name: 'events_query',
                            title: 'Events Query',
                            className: 'tab-two',
                            content: <><PanelBody>	
								
							<div className="ect_shortcode-button-group_label">{__("Events Time")}</div>
							<ButtonGroup className="ect_shortcode-button-group">
                    <Button onClick={(e) => {props.setAttributes({time: 'future'})}} className={props.attributes.time == 'future' ? 'active': ''} isSmall={true}>Future</Button>
                    <Button onClick={(e) => {props.setAttributes({time: 'past'})}} className={props.attributes.time == 'past' ? 'active': ''} isSmall={true}>Past</Button>
					<Button onClick={(e) => {props.setAttributes({time: 'all'})}} className={props.attributes.time == 'all' ? 'active': ''} isSmall={true}>All</Button>
                    </ButtonGroup>
					<div className="ect_shortcode-button-group_label">{__("Show Only Featured Events")}</div>
						
							<ButtonGroup className="ect_shortcode-button-group">
                    <Button onClick={(e) => {props.setAttributes({featuredonly: 'false'})}} className={props.attributes.featuredonly == 'false' ? 'active': ''} isSmall={true}>No</Button>
                    <Button onClick={(e) => {props.setAttributes({featuredonly: 'true'})}} className={props.attributes.featuredonly == 'true' ? 'active': ''} isSmall={true}>Yes</Button>
                    </ButtonGroup>
					<div className="ect_shortcode-button-group_label">{__("Events Order")}</div>
					<ButtonGroup className="ect_shortcode-button-group">
                    	<Button onClick={(e) => {props.setAttributes({order: 'ASC'})}} className={props.attributes.order == 'ASC' ? 'active': ''} isSmall={true}>ASC</Button>
                    	<Button onClick={(e) => {props.setAttributes({order: 'DESC'})}} className={props.attributes.order == 'DESC' ? 'active': ''} isSmall={true}>DESC</Button>
                    </ButtonGroup>
				</PanelBody>
					<Panel>
						<PanelBody title="🔶Filter Events By" initialOpen={ false }>
            			<PanelRow className="ect_shortcode-button-group_label">
							<SelectControl
								label={ __( 'Select Category' ) }
								options={ categoryList }
								value={ props.attributes.category }
								onChange={ ( value ) =>props.setAttributes( { category: value } ) }
								/>
						</PanelRow>
					<PanelRow className="ect_shortcode-button-group_label">
						<SelectControl
								label={ __( 'Select Tags' ) }
								options={ tagList }
								value={ props.attributes.tags }
								onChange={ ( value ) =>props.setAttributes( { tags: value } ) }
								/>
					</PanelRow>
					<PanelRow className="ect_shortcode-button-group_label">
						<SelectControl
								label={ __( 'Select Venue' ) }
								options={ venueList }
								value={ props.attributes.venues }
								onChange={ ( value ) =>props.setAttributes( { venues: value } ) }
						/>
					</PanelRow>
					<PanelRow className="ect_shortcode-button-group_label">
						<SelectControl
								label={ __( 'Select Organizer' ) }
								options={ organizerList }
								value={ props.attributes.organizers }
								onChange={ ( value ) =>props.setAttributes( { organizers: value } ) }
						/>
					</PanelRow>
					<PanelRow>
						<TextControl
								label={ __( 'Start Date | format(YY-MM-DD)' ) }
								value={ props.attributes.startDate }
								onChange={ ( value ) =>props.setAttributes( { startDate: value } ) }
						/>
					</PanelRow>
					<PanelRow>
						<TextControl
							label={ __( 'End Date | format(YY-MM-DD)' ) }
							value={ props.attributes.endDate }
							onChange={ ( value ) =>props.setAttributes( { endDate: value } ) }
						/>
					</PanelRow>
					<PanelRow>
					<p className="description">Note:-Show events from date range e.g( 2017-01-01 to 2017-02-05).
							Please dates in this format(YY-MM-DD)</p>
					</PanelRow>
					</PanelBody>
					</Panel>	
				</>
                },
                ] }
                >
                    { ( tab ) => <Card>{tab.content}</Card> }
                </TabPanel>
				
				</InspectorControls>
			),
			<div className={ props.className }>
			<LayoutType  LayoutImgPath={LayoutImgPath} layout={props.attributes.template} />
			<div class="ect-shortcode-block">
			[events-calendar-templates 
			category="{props.attributes.category}"
		    template="{props.attributes.template}" 
			style="{props.attributes.style}" 
			date_format="{props.attributes.dateformat}"
			start_date="{props.attributes.startDate}"
			end_date="{props.attributes.endDate}"
			limit="{props.attributes.limit}"
			order="{props.attributes.order}" 
			hide-venue="{props.attributes.hideVenue}"
			time="{props.attributes.time}"
			featured-only="{props.attributes.featuredonly}" 
			show-description="{props.attributes.showdescription}"
			columns="{props.attributes.columns}" 
			autoplay="{props.attributes.autoplay}"
			tags="{props.attributes.tags}"
			venues="{props.attributes.venues}"
			organizers="{props.attributes.organizers}"
			socialshare="{props.attributes.socialshare}"
			date-lbl="{props.attributes.datetxt}"
			time-lbl="{props.attributes.timetxt}"
			event-lbl="{props.attributes.evttitle}"
			desc-lbl="{props.attributes.desctxt}"
			location-lbl="{props.attributes.eventVenueTittle}"
			vm-lbl="{props.attributes.viewMoreTittle}"
			category-lbl="{props.attributes.cateTitle}"
			]	  
			</div>
			</div>
		];
	},
	// Defining the front-end interface
	save() {
		// Rendering in PHP
		return null;
	},
});

