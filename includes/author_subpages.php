<?php 

$people_sub_pages = array(
        'vote-history' => 'Vote History',
        'donations' => 'Donation History',
        'bio' => 'About'
    );
      
    add_filter('rewrite_rules_array', 'fsp_insertrules');
    add_filter('query_vars', 'fsp_insertqv');
      
    // Adding fake pages' rewrite rules
    function fsp_insertrules($rules)
    {
        global $people_sub_pages;
      
        $newrules = array();
        foreach ($people_sub_pages as $slug => $title)
            $newrules['people/([^/]+)/' . $slug . '/?$'] = 'index.php?people=$matches[1]&fpage=' . $slug;
      
        return $rules + $newrules;
    }
      
    // Tell WordPress to accept our custom query variable
    function fsp_insertqv($vars)
    {
        array_push($vars, 'fpage');
        return $vars;
    }
 
    // Remove WordPress's default canonical handling function
     
    remove_filter('wp_head', 'rel_canonical');
    add_filter('wp_head', 'fsp_rel_canonical');
    function fsp_rel_canonical()
    {
        global $current_fp, $wp_the_query;
      
        if (!is_singular())
            return;
      
        if (!$id = $wp_the_query->get_queried_object_id())
            return;
      
        $link = trailingslashit(get_permalink($id));
      
        // Make sure fake pages' permalinks are canonical
        if (!empty($current_fp))
            $link .= user_trailingslashit($current_fp);
      
        echo '<link rel="canonical" href="'.$link.'" />';
    }