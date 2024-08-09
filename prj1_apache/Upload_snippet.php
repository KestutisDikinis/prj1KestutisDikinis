<?php

    /*
        generate a suitable name for the new folder, 
        remove characters which might be troublesome
    */
    $userdir = str_replace( 
        array("'",'"','-'),
        array('','','_'),
        $_SESSION["PrID"]
    );



    /* 
        new path into which the files are saved
        It might be better to have the files 
        stored outside of the document root.
    */
    $savepath = 'bestanden/'. $_SESSION["PrID"].'/';



    /* create the folder if it does not exist */
    if( !file_exists( $savepath ) ) {
        mkdir( $savepath );
        chown( $savepath, $_SESSION["PrID"] );
        chmod( $savepath, 0644 );
    }


 if(isset($_POST["submit"]))
        {

          $filename = $_FILES['file1']['name'];
    if($filename != '')
    {
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $allowed = ['pdf', 'png', 'jpg', 'jpeg',  'gif'];
    
        //check if file type is valid
        if (in_array($ext, $allowed)){

            $path = 'bestanden/'. $_SESSION["PrID"].'/';
                
            
            move_uploaded_file($_FILES['file1']['tmp_name'],($path . $filename));
        }