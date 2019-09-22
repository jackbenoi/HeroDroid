<?php

return [

	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => '\\OAuth\\Common\\Storage\\Session',

	/**
	 * Consumers
	*/
	'consumers' => array(

		/**
		 * Facebook
		 */
        'Facebook' => array(
        	
        	// live
            'client_id'     => '140376079907596', #insert app id here
            'client_secret' => '9ea6f399704ce45202c7e95166402d95', #insert app secret here 

            // 'client_id'     => '120412771994733', #insert app id here
            // 'client_secret' => '577da2ecead90166f0128ee133bec456', #insert app secret here
            'scope'         => array('email')
        ),

        'Google' => array(
		    'client_id'     => '828354835055-6vkr1vrmu195oep0etqq81k90qrbb6rn.apps.googleusercontent.com', #insert Client ID
		    'client_secret' => 'CVyZImFhrt7dSqRGSLhlimsR', #inser Client Secret
		    'scope'         => array('userinfo_email', 'userinfo_profile'),
		),

		'Twitter' => array(
		    'client_id'     => 'raeBvHniAzJgglR5xLC95Wsjp', #insert Consumer Key (API Key)
		    'client_secret' => 'GYivZQpbzy06S6pqtu71JDhNTSuXKAqFxu7LPrW0xMatzF7g87', #Consumer Secret (API Secret)
		),
	)

];