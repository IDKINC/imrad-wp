<?php
class ImradImport
{

    public function __construct($headers = array(), $post_type = '')
    {
        add_action('admin_menu', array($this, 'imrad_import_page'));

        $this->headers = $headers;
        $this->post_type = $post_type;

    }

    public function imrad_import_page()
    {
        add_submenu_page(
            'edit.php?post_type=' . $this->post_type,
            __('Import', 'imrad'),
            'Import',
            'manage_options',

            'imrad_import__'. $this->post_type,
            array($this, 'imrad_import_page__content'),
            'dashicons-plus-alt',
            8
        );
    }

    public function imrad_import_page__content()
    {

        if (sanitize_textarea_field($_POST['import'])) {
            $csv = sanitize_textarea_field($_POST['import']);

            $this->import($csv);
        }
        echo "<h1>Import ".$this->post_type."</h1>";
        echo "Headers: " . join(',', $this->headers);

        ?>

<form method="POST" action="edit.php?post_type=<?=$this->post_type?>&page=imrad_import__<?=$this->post_type?>" >
  <textarea type="text" name="import" ></textarea><br />
<input type="submit" value="submit" />
</form>

    <?php
}


    private function import($csv = ''){

        $lines = explode( "\n", $csv );
        $headers = $this->headers;
        $data = array();
        foreach ( $lines as $line ) {
            $row = array();
            foreach ( str_getcsv( $line ) as $key => $field )
                $row[ $headers[ $key ] ] = $field;
            $row = array_filter( $row );
            $data[] = $row;
        }

        $parties = array('R' => 'Republican', 'D'=>'Democrat', 'I'=>'Independent', 'ID'=>'Independent');

        foreach($data as $record){

            $record['Party'] = ($parties[$record['Party']] ? $parties[$record['Party']]  : $record['Party'] );

            $args = array(
                'post_type' => $this->post_type,
                'posts_per_page' => 1,
                'name' => $record['Name']                );
            $unique_name_check = new WP_Query($args);
                if($unique_name_check->have_posts()){
                    
                    echo $record['Name'] . " Already Exists";
                    //todo update posts if people exists
                } else {
                    $this->createPost($record);
                }
        }
    }

    private function createPost($record){

            $metaArray = array();
            $taxArray = array();

            if($record['State']){
                $metaArray['state'] = $record['State'];
            }

            if($record['Population']){
                $metaArray['population'] = $record['Population'];
            }

            if($record['Motto']){
                $metaArray['motto'] = $record['Motto'];
            }


            if($record['Abbreviation']){
                $metaArray['abbreviation'] = $record['Abbreviation'];
            }


            if($record['Title']){
                $taxArray['job_title'] = $record['Title'];
            }
            if($record['Party']){
                $taxArray['party'] = $record['Party'];
            }



        $postarr = array(
            'post_title'    => wp_strip_all_tags( $record['Name'] ),
            'post_type' => $this->post_type,
            'post_content'  => ' ',
            'post_status'   => 'publish',
            'meta_input' => $metaArray,
            'tax_input' => $taxArray
          );


      return  wp_insert_post( $postarr );
    }

}
