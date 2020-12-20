<?php
class html {
        public function __Construct(){}
        private function defaults() {
               $js = array("https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js","https://code.jquery.com/ui/1.12.1/jquery-ui.min.js");
               $css = array("default.css" );
               foreach ($js as $item) {
                    $this->loadjs($item);     
               }
               foreach ($css as $item) {
                   $this->loadcss($item);
               }
                /*<html>
        <head>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
                <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
                <link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet">
        </head>
	<style>
	</style>*/
        }
        public function loadhtml($title) {
            echo "<!DOCTYPE html>";
            echo "<html>";
            echo "  <head>";
            echo "  <title>".$title."</title>";

        }
        public function loaddefaults() {
                $this->defaults();
        }

        public function loadjs($jsscript) {
            echo "  <script src=\"".$jsscript."\" type=\"text/javascript\"></script>";
            
           
        }
        public function loadcss($cssscript) {
            echo "  <link href=\"".$cssscript."\" rel=\"stylesheet\">";
        }
        public function loadbody() {
            echo "  </head>";
            echo "  <body>";
        }
        public function enddoc() {
            echo "  </body>";
            echo "</html>";
        }
}

