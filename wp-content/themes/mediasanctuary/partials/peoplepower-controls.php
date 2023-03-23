<form action="/peoplepower/" id="people-power-controls">
    Sort by:
    <select name="sort">
        <option value="recent"<?php if ($_GET['sort'] == 'recent') { echo ' selected="selected"'; } ?>>Recently updated</option>
        <option value="name"<?php if ($_GET['sort'] == 'name') { echo ' selected="selected"'; } ?>>First Name</option>
    </select>
</form>
