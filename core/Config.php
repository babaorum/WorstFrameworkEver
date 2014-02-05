<?php

    namespace core;

    class Config {

        /**
         * @var \ArrayObject
         */
        private static $config = array();

        static public function get($setting){

            $settingSegs = explode("::",$setting);
            $config = self::$config;

            foreach($settingSegs as $seg){

                if(array_key_exists($seg,$config)){

                    $config = $config[$seg];
                }
                else {
                    /* throw new exception */
                }
            }

            return $config;

        }

        static function add ($param = array()){

            self::$config[] = $param;

        }

    }