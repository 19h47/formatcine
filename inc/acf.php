<?php

add_filter('acf/prepare_field/name=event_color', 'change_acf_color_picker');

/**
 * Change ACF color picker for pot
 * 
 * @param  $field
 * @return $field
 */
function change_acf_color_picker( $field ) {


    ?><script>

        acf.add_filter('color_picker_args', function( args, $field ){
    
            // do something to args
            args.palettes = ['#6666d5', '#343471'];
    
    
            // return
            return args;
        
        });
        
    </script><?php

    return $field;
}