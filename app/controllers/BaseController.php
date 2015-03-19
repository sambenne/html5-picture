<?php

class BaseController extends Controller {

    public function __construct()
    {
        $_messages       = [ ];
        $_message_titles = [ ];

        if ( Session::has( "message" ) ) {
            $messages = Session::get( "message" );

            if ( ! is_array( $messages ) ) {
                $messages = [ $messages ];
            }

            foreach ( $messages as $message ) {
                $_messages[] = explode( '|', $message );
            }

            $_message_titles = [
                "info"    => [ "Info" ],
                "success" => [ "Success!" ],
                "error"   => [ "Error:" ]
            ];
        }

        View::share( "_messages", $_messages );
        View::share( "_message_titles", $_message_titles );
    }

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}
