<?php
if ( ! defined( 'ABSPATH' ) ) exit; 
add_action('admin_head', 'ppfpn_custom_styles');
add_action('admin_head', 'ppfpn_custom_scripts');

function ppfpn_custom_styles() {
  echo '<style>
    #ppfpn-admin {
      background-color:#b5b5b5;
      margin-bottom: -50px! important; 
    }
    #ppfpn-admin h2 {
      margin: 20px! important;
      padding-top: 20px! important;
    }
    #ppfpn-admin p {
      margin: 20px! important;
      line-height: 1.3;
      font-size: 14px;
      font-weight: 600;
    }
    #ppfpn-admin input.wide {
      width:500px;
    }
    .ppfpn_form_section {
      background-color:#b5b5b5; 
      margin-bottom:30px;
      padding:30px;
    }
    input[type=text] {
      background-image: none! important;
    }
    .form-table {
      margin: 20px;
      width: 80%;
    }
    .ppfpn_bottom {
      padding-bottom: 30px;
    {
  </style>';
}

function ppfpn_custom_scripts() {
  echo '
  <script>
    jQuery(document).ready(function($) {
      $(".ppfpn_form_section .enable").each(function() {
        $row = $(this).closest("tr").siblings();
        
        if ($(this).is(":checked")) {
          console.log("show");
          $row.show();
        }
        else {
          console.log("hide");
          $row.hide();
        }
      });
    
      $(".ppfpn_form_section .enable").click(function() {
        $row = $(this).closest("tr").siblings();
        $row.toggle();
      });
    });
  </script>';
}
?>