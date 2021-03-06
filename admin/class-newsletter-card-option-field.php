<?php

if ( !class_exists( 'Newsletter_Card_Option_Field' ) ) {
    class Newsletter_Card_Option_Field {

        private $option_name;
        private $type;
        private $section;
        private $field_id;
        private $field_title;
        private $is_required;
        private $hint;

        /**
         * Newsletter_Card_Option_Field constructor.
         * @param $array
         */
        public function __construct( $array ) {
            $this->option_name = $array['option_name'];
            $this->type        = $array['type'];
            $this->section     = $array['section'];
            $this->field_id    = $array['field_id'];
            $this->field_title = $array['field_title'];
            $this->is_required = $array['is_required'];
            $this->hint        = $array['hint'];
        }

        /**
         * @return mixed
         */
        public function get_option_name() {
            return $this->option_name;
        }

        /**
         * @return mixed
         */
        public function get_type() {
            return $this->type;
        }

        /**
         * @return mixed
         */
        public function get_section() {
            return $this->section;
        }

        /**
         * @return mixed
         */
        public function get_field_id() {
            return $this->field_id;
        }

        /**
         * @return mixed
         */
        public function get_field_title() {
            return $this->field_title;
        }

        /**
         * @return mixed
         */
        public function is_required() {
            return $this->is_required;
        }

        /**
         * @return mixed
         */
        public function get_hint() {
            return $this->hint;
        }

    }
}