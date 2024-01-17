<?php 
namespace mv\components\header;

class Header {
    public $html = '';

    public function __construct(){

        $this->html .= '<div id="header-container" class="header-container" >';


            //LOGO
            $this->html .= '<img class="header-logo" src="'.get_template_directory_uri().'/assets/images/maillot-vert-logo.svg" alt="Maillot Vert Logo"/>';
            
      
            //SPRACHMENU
            
            $this->html .=  '<div id="languagebutton">';

                //display language menu
                $languages = icl_get_languages('');
                //var_dump($languages );
                if(1 < count($languages))
                {
                    foreach($languages as $l)
                    {
                        if( $l["active"] == 1 ){
                            $this->html .= '<div class="lang-btn"><button class=" active-language">' . $l['language_code'] . '</button></div>';
                        } else {
                            $this->html .= '<div class="lang-btn"><a href="' . $l['url'] . '"><button>' . $l['language_code'] . '</button></a></div>';
                        }
                    }
                        
                }

            $this->html .=  '</div>'; 
            
        $this->html .= '</div>';
        
        return $this->html;
    } 
}