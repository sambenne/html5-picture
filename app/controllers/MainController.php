<?php

class MainController extends BaseController {

    private $sizes = [
        '2400',
        '1800',
        '1400',
        '1280',
        '1024',
        '800',
        '640',
        '480',
        '320',
    ];

	public function index()
	{
		return View::make('main.index');
	}

    public function generate()
    {
        // Build the input for our validation
        $input = [ 'image' => Input::file('image'), 'aspect' => Input::get('aspect') ];

        // Within the ruleset, make sure we let the validator know that this
        // file should be an image
        $rules = [
            'image' => 'image',
            'aspect' => 'required'
        ];

        // Now pass the input and rules into the validator
        $validator = Validator::make($input, $rules);

        // Check to see if validation fails or passes
        if ($validator->fails()) {
            // Redirect with a helpful message to inform the user that
            // the provided file was not an adequate type
            return Redirect::to('/')->with('message', 'Error: The provided file was not an image|danger');
        } else {
            $image = Input::file('image');
            $temp = Image::make($image);
            $filename = basename($image->getClientOriginalName(), '.' . $image->getClientOriginalExtension());
            $time = time();
            $folder = '/generated/' . $filename . '_' . $time;
            $structure = public_path() . $folder;

            if (!mkdir($structure, 0777, true)) {
                die('Failed to create folders...');
            }

            $images = [];
            $default = [];

            for( $i = 0, $c = count($this->sizes); $i < $c; $i++ ) {
                $width = (int) $this->sizes[$i];
                if( $width <= $temp->width() ) {
                    $height = round(($width / (float) $input['aspect']));

                    $images[] = [
                        'width' => $width,
                        'name' => $filename . "_w{$width}h{$height}." . $image->getClientOriginalExtension(),
                        'name2x' => $filename . "_w{$width}h{$height}@2x." . $image->getClientOriginalExtension(),
                        'name3x' => $filename . "_w{$width}h{$height}@3x." . $image->getClientOriginalExtension()
                    ];

                    if( (int) $width == 1024 ) {
                        $default = [
                            'width' => $width,
                            'name' => $filename . "_w{$width}h{$height}." . $image->getClientOriginalExtension(),
                            'name2x' => $filename . "_w{$width}h{$height}@2x." . $image->getClientOriginalExtension(),
                            'name3x' => $filename . "_w{$width}h{$height}@3x." . $image->getClientOriginalExtension()
                        ];
                    }

                    $temp->fit($width, $height);
                    $temp->save($structure . '/' . $filename . "_w{$width}h{$height}." . $image->getClientOriginalExtension());
                }
            }

            $directory = Input::get('directory');
            $html = View::make('templates.full')
                ->with('images', $images)
                ->with('folder', (empty($directory) ? '' : $directory . $filename . '_' . $time . '/'))
                ->with('default', $default);

            $test = View::make('templates.full')
                        ->with('folder', $folder . '/')
                        ->with('images', $images)
                        ->with('default', $default);

            return Redirect::route('main')->with('message', 'Success: File upload was successful|success')
                ->with('output', $html->render())
                ->with('test', $test->render());
        }
    }
}
