<?php
    class room{
        private $bgColor;
        private $textColor1;
        private $textColor2;
        private $bgPost;
        
        public function getTextColor1(){
            if($this->textColor1!='0')
                return $this->textColor1;
            else 
                return "#FFF";
        }
        
        public function getTextColor2(){
            if($this->textColor2!='0')
                return $this->textColor2;
            else
                return "#55F";
        }
        
        public function getBg(){
            if($this->bgColor!='0')
                return $this->bgColor;
            else 
                return "url('./css/img/bg.jpg) repeat";
        }
        
        public function getBgPost(){
            return $this->bgPost;
        }
    }
?>