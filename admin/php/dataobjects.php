<?php
/*
FIELDS
id
parent_id
title
short_description
description
photo
product_image
level
nodes
active
*/
class app_categories
{

protected $_myconn, $_id, $_parent_id, $_title, $_short_description, $_description, $_photo, $_product_image, $_level, $_nodes, $_active ;

public function __construct($myconn, $_id, $my_rows = NULL, $_ssql = '') { 
    $all_rows = NULL; 
    $this->_id = $_id; 
    $this->_myconn = $myconn; 
    if ($my_rows==NULL) { 
        $ssql = "SELECT * FROM app_categories WHERE id=?"; 
        $all_rows = $this->_myconn->getRS($ssql, array($_id)); 
        } 
    else if ($_ssql!='') { 
        $ssql = $_ssql; 
        $all_rows = $this->_myconn->getRS($ssql); 
        } 
    else { 
        $rows = $my_rows; 
        $all_rows = arrayfunctions::filter_by_value($rows, 'id', $this->_id); 
    }
    $icount = $all_rows? count($all_rows): 0; 

    if ($icount==1) { 
        $this->_parent_id = $all_rows[0]['parent_id']; 
        $this->_title = $all_rows[0]['title']; 
        $this->_short_description = $all_rows[0]['short_description']; 
        $this->_description = $all_rows[0]['description']; 
        $this->_photo = $all_rows[0]['photo']; 
        $this->_product_image = $all_rows[0]['product_image']; 
        $this->_level = $all_rows[0]['level']; 
        $this->_nodes = $all_rows[0]['nodes']; 
        $this->_active = $all_rows[0]['active']; 
    } 
} 

public function get_id() { 
    return $this->_id; 
} 

public function parent_id($val = NULL) { 
    if ($val === NULL) {        return $this->_parent_id; 
    } 
    else {        $this->_parent_id = $val; 
    }
} 

public function title($val = NULL) { 
    if ($val === NULL) {        return $this->_title; 
    } 
    else {        $this->_title = $val; 
    }
} 

public function short_description($val = NULL) { 
    if ($val === NULL) {        return $this->_short_description; 
    } 
    else {        $this->_short_description = $val; 
    }
} 

public function description($val = NULL) { 
    if ($val === NULL) {        return $this->_description; 
    } 
    else {        $this->_description = $val; 
    }
} 

public function photo($val = NULL) { 
    if ($val === NULL) {        return $this->_photo; 
    } 
    else {        $this->_photo = $val; 
    }
} 

public function product_image($val = NULL) { 
    if ($val === NULL) {        return $this->_product_image; 
    } 
    else {        $this->_product_image = $val; 
    }
} 

public function level($val = NULL) { 
    if ($val === NULL) {        return $this->_level; 
    } 
    else {        $this->_level = $val; 
    }
} 

public function nodes($val = NULL) { 
    if ($val === NULL) {        return $this->_nodes; 
    } 
    else {        $this->_nodes = $val; 
    }
} 

public function active($val = NULL) { 
    if ($val === NULL) {        return $this->_active; 
    } 
    else {        $this->_active = $val; 
    }
} 

public function Savedata() { 
    if ($this->_id==0) { 
    $ssql = "INSERT INTO app_categories ( 
    parent_id,
    title,
    short_description,
    description,
    photo,
    product_image,
    level,
    nodes,
    active
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"; 
    $result = $this->_myconn->execSQL($ssql, array( 
        $this->_parent_id, 
        $this->_title, 
        $this->_short_description, 
        $this->_description, 
        $this->_photo, 
        $this->_product_image, 
        $this->_level, 
        $this->_nodes, 
        $this->_active)); 
    $ssql = $this->_myconn->getLastIDsql('app_categories');

        $newrows = $this->_myconn->getRS($ssql); 
        $this->_id = $newrows[0]['id']; 
    } 
    else { 
        $ssql = "UPDATE app_categories set 
        parent_id = ?, 
        title = ?, 
        short_description = ?, 
        description = ?, 
        photo = ?, 
        product_image = ?, 
        level = ?, 
        nodes = ?, 
        active = ?
        WHERE id = ?"; 
        $result = $this->_myconn->execSQL($ssql, array( 
        $this->_parent_id, 
        $this->_title, 
        $this->_short_description, 
        $this->_description, 
        $this->_photo, 
        $this->_product_image, 
        $this->_level, 
        $this->_nodes, 
        $this->_active,
        $this->_id));
    } 
    if ($result===false) { 
        return false; 
    } 
    return true; 
} 

public function Delete() { 
    $ssql = "DELETE FROM app_categories WHERE id=?"; 
    $result = $this->_myconn->execSQL($ssql, array($this->_id)); 
    if ($result===false) { 
        return false; 
    } 
else { 
    return true; 
}
} 

}





/*
FIELDS
id
category_id
item_code
title
short_description
description
features_benefits
photo
extra_images
downloads
related_product_ids
accessories_ids
cleaning_agents_ids
compatible_machines_ids
standard_accessories_ids
active
clicks_counter
aux
adapter_category
*/
class app_products
{

protected $_myconn, $_id, $_category_id, $_item_code, $_title, $_short_description, $_description, $_features_benefits, $_photo, $_extra_images, $_downloads, $_related_product_ids, $_accessories_ids, $_cleaning_agents_ids, $_compatible_machines_ids, $_standard_accessories_ids, $_active, $_clicks_counter, $_aux, $_adapter_category ;

public function __construct($myconn, $_id, $my_rows = NULL, $_ssql = '') { 
    $all_rows = NULL; 
    $this->_id = $_id; 
    $this->_myconn = $myconn; 
    if ($my_rows==NULL) { 
        $ssql = "SELECT * FROM app_products WHERE id=?"; 
        $all_rows = $this->_myconn->getRS($ssql, array($_id)); 
        } 
    else if ($_ssql!='') { 
        $ssql = $_ssql; 
        $all_rows = $this->_myconn->getRS($ssql); 
        } 
    else { 
        $rows = $my_rows; 
        $all_rows = arrayfunctions::filter_by_value($rows, 'id', $this->_id); 
    }
    $icount = $all_rows? count($all_rows): 0; 

    if ($icount==1) { 
        $this->_category_id = $all_rows[0]['category_id']; 
        $this->_item_code = $all_rows[0]['item_code']; 
        $this->_title = $all_rows[0]['title']; 
        $this->_short_description = $all_rows[0]['short_description']; 
        $this->_description = $all_rows[0]['description']; 
        $this->_features_benefits = $all_rows[0]['features_benefits']; 
        $this->_photo = $all_rows[0]['photo']; 
        $this->_extra_images = $all_rows[0]['extra_images']; 
        $this->_downloads = $all_rows[0]['downloads']; 
        $this->_related_product_ids = $all_rows[0]['related_product_ids']; 
        $this->_accessories_ids = $all_rows[0]['accessories_ids']; 
        $this->_cleaning_agents_ids = $all_rows[0]['cleaning_agents_ids']; 
        $this->_compatible_machines_ids = $all_rows[0]['compatible_machines_ids']; 
        $this->_standard_accessories_ids = $all_rows[0]['standard_accessories_ids']; 
        $this->_active = $all_rows[0]['active']; 
        $this->_clicks_counter = $all_rows[0]['clicks_counter']; 
        $this->_aux = $all_rows[0]['aux']; 
        $this->_adapter_category = $all_rows[0]['adapter_category']; 
    } 
} 

public function get_id() { 
    return $this->_id; 
} 

public function category_id($val = NULL) { 
    if ($val === NULL) {        return $this->_category_id; 
    } 
    else {        $this->_category_id = $val; 
    }
} 

public function item_code($val = NULL) { 
    if ($val === NULL) {        return $this->_item_code; 
    } 
    else {        $this->_item_code = $val; 
    }
} 

public function title($val = NULL) { 
    if ($val === NULL) {        return $this->_title; 
    } 
    else {        $this->_title = $val; 
    }
} 

public function short_description($val = NULL) { 
    if ($val === NULL) {        return $this->_short_description; 
    } 
    else {        $this->_short_description = $val; 
    }
} 

public function description($val = NULL) { 
    if ($val === NULL) {        return $this->_description; 
    } 
    else {        $this->_description = $val; 
    }
} 

public function features_benefits($val = NULL) { 
    if ($val === NULL) {        return $this->_features_benefits; 
    } 
    else {        $this->_features_benefits = $val; 
    }
} 

public function photo($val = NULL) { 
    if ($val === NULL) {        return $this->_photo; 
    } 
    else {        $this->_photo = $val; 
    }
} 

public function extra_images($val = NULL) { 
    if ($val === NULL) {        return $this->_extra_images; 
    } 
    else {        $this->_extra_images = $val; 
    }
} 

public function downloads($val = NULL) { 
    if ($val === NULL) {        return $this->_downloads; 
    } 
    else {        $this->_downloads = $val; 
    }
} 

public function related_product_ids($val = NULL) { 
    if ($val === NULL) {        return $this->_related_product_ids; 
    } 
    else {        $this->_related_product_ids = $val; 
    }
} 

public function accessories_ids($val = NULL) { 
    if ($val === NULL) {        return $this->_accessories_ids; 
    } 
    else {        $this->_accessories_ids = $val; 
    }
} 

public function cleaning_agents_ids($val = NULL) { 
    if ($val === NULL) {        return $this->_cleaning_agents_ids; 
    } 
    else {        $this->_cleaning_agents_ids = $val; 
    }
} 

public function compatible_machines_ids($val = NULL) { 
    if ($val === NULL) {        return $this->_compatible_machines_ids; 
    } 
    else {        $this->_compatible_machines_ids = $val; 
    }
} 

public function standard_accessories_ids($val = NULL) { 
    if ($val === NULL) {        return $this->_standard_accessories_ids; 
    } 
    else {        $this->_standard_accessories_ids = $val; 
    }
} 

public function active($val = NULL) { 
    if ($val === NULL) {        return $this->_active; 
    } 
    else {        $this->_active = $val; 
    }
} 

public function clicks_counter($val = NULL) { 
    if ($val === NULL) {        return $this->_clicks_counter; 
    } 
    else {        $this->_clicks_counter = $val; 
    }
} 

public function aux($val = NULL) { 
    if ($val === NULL) {        return $this->_aux; 
    } 
    else {        $this->_aux = $val; 
    }
} 

public function adapter_category($val = NULL) { 
    if ($val === NULL) {        return $this->_adapter_category; 
    } 
    else {        $this->_adapter_category = $val; 
    }
} 

public function Savedata() { 
    if ($this->_id==0) { 
    $ssql = "INSERT INTO app_products ( 
    category_id,
    item_code,
    title,
    short_description,
    description,
    features_benefits,
    photo,
    extra_images,
    downloads,
    related_product_ids,
    accessories_ids,
    cleaning_agents_ids,
    compatible_machines_ids,
    standard_accessories_ids,
    active,
    clicks_counter,
    aux,
    adapter_category
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"; 
    $result = $this->_myconn->execSQL($ssql, array( 
        $this->_category_id, 
        $this->_item_code, 
        $this->_title, 
        $this->_short_description, 
        $this->_description, 
        $this->_features_benefits, 
        $this->_photo, 
        $this->_extra_images, 
        $this->_downloads, 
        $this->_related_product_ids, 
        $this->_accessories_ids, 
        $this->_cleaning_agents_ids, 
        $this->_compatible_machines_ids, 
        $this->_standard_accessories_ids, 
        $this->_active, 
        $this->_clicks_counter, 
        $this->_aux, 
        $this->_adapter_category)); 
    $ssql = $this->_myconn->getLastIDsql('app_products');

        $newrows = $this->_myconn->getRS($ssql); 
        $this->_id = $newrows[0]['id']; 
    } 
    else { 
        $ssql = "UPDATE app_products set 
        category_id = ?, 
        item_code = ?, 
        title = ?, 
        short_description = ?, 
        description = ?, 
        features_benefits = ?, 
        photo = ?, 
        extra_images = ?, 
        downloads = ?, 
        related_product_ids = ?, 
        accessories_ids = ?, 
        cleaning_agents_ids = ?, 
        compatible_machines_ids = ?, 
        standard_accessories_ids = ?, 
        active = ?, 
        clicks_counter = ?, 
        aux = ?, 
        adapter_category = ?
        WHERE id = ?"; 
        $result = $this->_myconn->execSQL($ssql, array( 
        $this->_category_id, 
        $this->_item_code, 
        $this->_title, 
        $this->_short_description, 
        $this->_description, 
        $this->_features_benefits, 
        $this->_photo, 
        $this->_extra_images, 
        $this->_downloads, 
        $this->_related_product_ids, 
        $this->_accessories_ids, 
        $this->_cleaning_agents_ids, 
        $this->_compatible_machines_ids, 
        $this->_standard_accessories_ids, 
        $this->_active, 
        $this->_clicks_counter, 
        $this->_aux, 
        $this->_adapter_category,
        $this->_id));
    } 
    if ($result===false) { 
        return false; 
    } 
    return true; 
} 

public function Delete() { 
    $ssql = "DELETE FROM app_products WHERE id=?"; 
    $result = $this->_myconn->execSQL($ssql, array($this->_id)); 
    if ($result===false) { 
        return false; 
    } 
else { 
    return true; 
}
} 

}









/*
FIELDS
id
title
description
attr_type_id
attr_category_id
*/
class app_attributes
{

protected $_myconn, $_id, $_title, $_description, $_attr_type_id, $_attr_category_id ;

public function __construct($myconn, $_id, $my_rows = NULL, $_ssql = '') {
    $all_rows = NULL;
    $this->_id = $_id;
    $this->_myconn = $myconn;
    if ($my_rows==NULL) {
        $ssql = "SELECT * FROM app_attributes WHERE id=?";
        $all_rows = $this->_myconn->getRS($ssql, array($_id));
        }
    else if ($_ssql!='') {
        $ssql = $_ssql;
        $all_rows = $this->_myconn->getRS($ssql);
        }
    else {
        $rows = $my_rows;
        $all_rows = arrayfunctions::filter_by_value($rows, 'id', $this->_id);
    }
    $icount = $all_rows? count($all_rows): 0;

    if ($icount==1) {
        $this->_title = $all_rows[0]['title'];
        $this->_description = $all_rows[0]['description'];
        $this->_attr_type_id = $all_rows[0]['attr_type_id'];
        $this->_attr_category_id = $all_rows[0]['attr_category_id'];
    }
}

public function get_id() {
    return $this->_id;
}

public function title($val = NULL) {
    if ($val === NULL) {        return $this->_title;
    }
    else {        $this->_title = $val;
    }
}

public function description($val = NULL) {
    if ($val === NULL) {        return $this->_description;
    }
    else {        $this->_description = $val;
    }
}

public function attr_type_id($val = NULL) {
    if ($val === NULL) {        return $this->_attr_type_id;
    }
    else {        $this->_attr_type_id = $val;
    }
}

public function attr_category_id($val = NULL) {
    if ($val === NULL) {        return $this->_attr_category_id;
    }
    else {        $this->_attr_category_id = $val;
    }
}

public function Savedata() {
    if ($this->_id==0) {
    $ssql = "INSERT INTO app_attributes (
    title,
    description,
    attr_type_id,
    attr_category_id
    ) VALUES (?, ?, ?, ?)";
    $result = $this->_myconn->execSQL($ssql, array(
        $this->_title,
        $this->_description,
        $this->_attr_type_id,
        $this->_attr_category_id));
    $ssql = $this->_myconn->getLastIDsql('app_attributes');

        $newrows = $this->_myconn->getRS($ssql);
        $this->_id = $newrows[0]['id'];
    }
    else {
        $ssql = "UPDATE app_attributes set
        title = ?,
        description = ?,
        attr_type_id = ?,
        attr_category_id = ?
        WHERE id = ?";
        $result = $this->_myconn->execSQL($ssql, array(
        $this->_title,
        $this->_description,
        $this->_attr_type_id,
        $this->_attr_category_id,
        $this->_id));
    }
    if ($result===false) {
        return false;
    }
    return true;
}

public function Delete() {
    $ssql = "DELETE FROM app_attributes WHERE id=?";
    $result = $this->_myconn->execSQL($ssql, array($this->_id));
    if ($result===false) {
        return false;
    }
else {
    return true;
}
}

} 

/*
FIELDS
id
description
*/
class app_attr_categories
{

protected $_myconn, $_id, $_description ;

public function __construct($myconn, $_id, $my_rows = NULL, $_ssql = '') {
    $all_rows = NULL;
    $this->_id = $_id;
    $this->_myconn = $myconn;
    if ($my_rows==NULL) {
        $ssql = "SELECT * FROM app_attr_categories WHERE id=?";
        $all_rows = $this->_myconn->getRS($ssql, array($_id));
        }
    else if ($_ssql!='') {
        $ssql = $_ssql;
        $all_rows = $this->_myconn->getRS($ssql);
        }
    else {
        $rows = $my_rows;
        $all_rows = arrayfunctions::filter_by_value($rows, 'id', $this->_id);
    }
    $icount = $all_rows? count($all_rows): 0;

    if ($icount==1) {
        $this->_description = $all_rows[0]['description'];
    }
}

public function get_id() {
    return $this->_id;
}

public function description($val = NULL) {
    if ($val === NULL) {        return $this->_description;
    }
    else {        $this->_description = $val;
    }
}

public function Savedata() {
    if ($this->_id==0) {
    $ssql = "INSERT INTO app_attr_categories (
    description
    ) VALUES (?)";
    $result = $this->_myconn->execSQL($ssql, array(
        $this->_description));
    $ssql = $this->_myconn->getLastIDsql('app_attr_categories');

        $newrows = $this->_myconn->getRS($ssql);
        $this->_id = $newrows[0]['id'];
    }
    else {
        $ssql = "UPDATE app_attr_categories set
        description = ?
        WHERE id = ?";
        $result = $this->_myconn->execSQL($ssql, array(
        $this->_description,
        $this->_id));
    }
    if ($result===false) {
        return false;
    }
    return true;
}

public function Delete() {
    $ssql = "DELETE FROM app_attr_categories WHERE id=?";
    $result = $this->_myconn->execSQL($ssql, array($this->_id));
    if ($result===false) {
        return false;
    }
else {
    return true;
}
}

} 

/*
FIELDS
id
description
*/
class app_attr_types
{

protected $_myconn, $_id, $_description ;

public function __construct($myconn, $_id, $my_rows = NULL, $_ssql = '') {
    $all_rows = NULL;
    $this->_id = $_id;
    $this->_myconn = $myconn;
    if ($my_rows==NULL) {
        $ssql = "SELECT * FROM app_attr_types WHERE id=?";
        $all_rows = $this->_myconn->getRS($ssql, array($_id));
        }
    else if ($_ssql!='') {
        $ssql = $_ssql;
        $all_rows = $this->_myconn->getRS($ssql);
        }
    else {
        $rows = $my_rows;
        $all_rows = arrayfunctions::filter_by_value($rows, 'id', $this->_id);
    }
    $icount = $all_rows? count($all_rows): 0;

    if ($icount==1) {
        $this->_description = $all_rows[0]['description'];
    }
}

public function get_id() {
    return $this->_id;
}

public function description($val = NULL) {
    if ($val === NULL) {        return $this->_description;
    }
    else {        $this->_description = $val;
    }
}

public function Savedata() {
    if ($this->_id==0) {
    $ssql = "INSERT INTO app_attr_types (
    description
    ) VALUES (?)";
    $result = $this->_myconn->execSQL($ssql, array(
        $this->_description));
    $ssql = $this->_myconn->getLastIDsql('app_attr_types');

        $newrows = $this->_myconn->getRS($ssql);
        $this->_id = $newrows[0]['id'];
    }
    else {
        $ssql = "UPDATE app_attr_types set
        description = ?
        WHERE id = ?";
        $result = $this->_myconn->execSQL($ssql, array(
        $this->_description,
        $this->_id));
    }
    if ($result===false) {
        return false;
    }
    return true;
}

public function Delete() {
    $ssql = "DELETE FROM app_attr_types WHERE id=?";
    $result = $this->_myconn->execSQL($ssql, array($this->_id));
    if ($result===false) {
        return false;
    }
else {
    return true;
}
}

} 

/*
FIELDS
id
product_id
attribute_id
value
attr_order
*/
class app_product_attributes
{

protected $_myconn, $_id, $_product_id, $_attribute_id, $_value, $_attr_order ;

public function __construct($myconn, $_id, $my_rows = NULL, $_ssql = '') {
    $all_rows = NULL;
    $this->_id = $_id;
    $this->_myconn = $myconn;
    if ($my_rows==NULL) {
        $ssql = "SELECT * FROM app_product_attributes WHERE id=?";
        $all_rows = $this->_myconn->getRS($ssql, array($_id));
        }
    else if ($_ssql!='') {
        $ssql = $_ssql;
        $all_rows = $this->_myconn->getRS($ssql);
        }
    else {
        $rows = $my_rows;
        $all_rows = arrayfunctions::filter_by_value($rows, 'id', $this->_id);
    }
    $icount = $all_rows? count($all_rows): 0;

    if ($icount==1) {
        $this->_product_id = $all_rows[0]['product_id'];
        $this->_attribute_id = $all_rows[0]['attribute_id'];
        $this->_value = $all_rows[0]['value'];
        $this->_attr_order = $all_rows[0]['attr_order'];
    }
}

public function get_id() {
    return $this->_id;
}

public function product_id($val = NULL) {
    if ($val === NULL) {        return $this->_product_id;
    }
    else {        $this->_product_id = $val;
    }
}

public function attribute_id($val = NULL) {
    if ($val === NULL) {        return $this->_attribute_id;
    }
    else {        $this->_attribute_id = $val;
    }
}

public function value($val = NULL) {
    if ($val === NULL) {        return $this->_value;
    }
    else {        $this->_value = $val;
    }
}

public function attr_order($val = NULL) {
    if ($val === NULL) {        return $this->_attr_order;
    }
    else {        $this->_attr_order = $val;
    }
}

public function Savedata() {
    if ($this->_id==0) {
    $ssql = "INSERT INTO app_product_attributes (
    product_id,
    attribute_id,
    value,
    attr_order
    ) VALUES (?, ?, ?, ?)";
    $result = $this->_myconn->execSQL($ssql, array(
        $this->_product_id,
        $this->_attribute_id,
        $this->_value,
        $this->_attr_order));
    $ssql = $this->_myconn->getLastIDsql('app_product_attributes');

        $newrows = $this->_myconn->getRS($ssql);
        $this->_id = $newrows[0]['id'];
    }
    else {
        $ssql = "UPDATE app_product_attributes set
        product_id = ?,
        attribute_id = ?,
        value = ?,
        attr_order = ?
        WHERE id = ?";
        $result = $this->_myconn->execSQL($ssql, array(
        $this->_product_id,
        $this->_attribute_id,
        $this->_value,
        $this->_attr_order,
        $this->_id));
    }
    if ($result===false) {
        return false;
    }
    return true;
}

public function Delete() {
    $ssql = "DELETE FROM app_product_attributes WHERE id=?";
    $result = $this->_myconn->execSQL($ssql, array($this->_id));
    if ($result===false) {
        return false;
    }
else {
    return true;
}
}

} 


/*
FIELDS
id
product1
product2
adapter
*/
class app_adapter_data
{

protected $_myconn, $_id, $_product1, $_product2, $_adapter ;

public function __construct($myconn, $_id, $my_rows = NULL, $_ssql = '') { 
    $all_rows = NULL; 
    $this->_id = $_id; 
    $this->_myconn = $myconn; 
    if ($my_rows==NULL) { 
        $ssql = "SELECT * FROM app_adapter_data WHERE id=?"; 
        $all_rows = $this->_myconn->getRS($ssql, array($_id)); 
        } 
    else if ($_ssql!='') { 
        $ssql = $_ssql; 
        $all_rows = $this->_myconn->getRS($ssql); 
        } 
    else { 
        $rows = $my_rows; 
        $all_rows = arrayfunctions::filter_by_value($rows, 'id', $this->_id); 
    }
    $icount = $all_rows? count($all_rows): 0; 

    if ($icount==1) { 
        $this->_product1 = $all_rows[0]['product1']; 
        $this->_product2 = $all_rows[0]['product2']; 
        $this->_adapter = $all_rows[0]['adapter']; 
    } 
} 

public function get_id() { 
    return $this->_id; 
} 

public function product1($val = NULL) { 
    if ($val === NULL) {        return $this->_product1; 
    } 
    else {        $this->_product1 = $val; 
    }
} 

public function product2($val = NULL) { 
    if ($val === NULL) {        return $this->_product2; 
    } 
    else {        $this->_product2 = $val; 
    }
} 

public function adapter($val = NULL) { 
    if ($val === NULL) {        return $this->_adapter; 
    } 
    else {        $this->_adapter = $val; 
    }
} 

public function Savedata() { 
    if ($this->_id==0) { 
    $ssql = "INSERT INTO app_adapter_data ( 
    product1,
    product2,
    adapter
    ) VALUES (?, ?, ?)"; 
    $result = $this->_myconn->execSQL($ssql, array( 
        $this->_product1, 
        $this->_product2, 
        $this->_adapter)); 
    $ssql = $this->_myconn->getLastIDsql('app_adapter_data');

        $newrows = $this->_myconn->getRS($ssql); 
        $this->_id = $newrows[0]['id']; 
    } 
    else { 
        $ssql = "UPDATE app_adapter_data set 
        product1 = ?, 
        product2 = ?, 
        adapter = ?
        WHERE id = ?"; 
        $result = $this->_myconn->execSQL($ssql, array( 
        $this->_product1, 
        $this->_product2, 
        $this->_adapter,
        $this->_id));
    } 
    if ($result===false) { 
        return false; 
    } 
    return true; 
} 

public function Delete() { 
    $ssql = "DELETE FROM app_adapter_data WHERE id=?"; 
    $result = $this->_myconn->execSQL($ssql, array($this->_id)); 
    if ($result===false) { 
        return false; 
    } 
else { 
    return true; 
}
} 

}


?>