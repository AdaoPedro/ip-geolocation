<?php
    namespace AdaoPedro\IPGeolocation;

    final class IPGeolocation {

        const IP_GEOLOCATION_WEB_SERVICE = "http://www.geoplugin.net/";

        /**
         * @return string[]
         */
        public function Get ( ?string $ipAddress = null ): array {

            if ( $ipAddress === null ) $ipAddress = $this->getIP();

            if ( !$this->IPAdressIsValid($ipAddress) ) throw new \Exception("IP Adress invalid");

            /**
             * @var string[] $geolocationData
             */
            $geolocationData = (array) \json_decode(
                file_get_contents(IPGeolocation::IP_GEOLOCATION_WEB_SERVICE . "json.gp?ip=$ipAddress"),
                true
            );

            return $this->filterFields($geolocationData);
        }

        private function IPAdressIsValid (string $ipAddress): bool {
            return \filter_var(
                $ipAddress, \FILTER_VALIDATE_IP
            );
        }

        /**
         * @param string[] $geolocationData
         * @return string[]
         */
        private function filterFields (array $geolocationData): array {
            return [
                "CountryName" => (string) $geolocationData["geoplugin_countryName"],
                "CityName" => (string) $geolocationData["geoplugin_city"],
                "ContinentName" => (string) $geolocationData["geoplugin_continentName"],
                "Latitude" => (string) $geolocationData["geoplugin_latitude"],
                "Longitude" => (string) $geolocationData["geoplugin_longitude"],
                "CurrencySymbol" => (string) $geolocationData["geoplugin_currencySymbol"],
                "CurrencyCode" => (string) $geolocationData["geoplugin_currencyCode"],
                "Timezone" => (string) $geolocationData["geoplugin_timezone"]
            ];
        }

        private function getIP (): string {
            if ( !empty($_SERVER['HTTP_CLIENT_IP']) ) { 
                return $_SERVER['HTTP_CLIENT_IP']; 
            } 
            
            if ( !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) { 
                return $_SERVER['HTTP_X_FORWARDED_FOR']; 
            }

            return $_SERVER['REMOTE_ADDR']; 
 
        }

    }