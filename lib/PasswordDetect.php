<?php
/*
    Detect weak password in a web application with dictionary and brute force attack

    @author: Istvan Dobrentei
    @url: https://github.com/distvan/password-detect
*/
class PasswordDetect
{
    protected $_url;
    private $_lowerAlpha;
    private $_combinations;
    private $_successLoginTest;

    public function __construct($url)
    {
        $this->_lowerAlpha = range('a', 'z');
        $this->_url = $url;
        $this->_combinations = $this->letsDo($this->_lowerAlpha, 4);
        $this->_successLoginTest = '<div class="warning">';
    }

    protected function letsDo($chars, $size, $combinations = array())
    {
        if(empty($combinations))
        {
            $combinations = $chars;
        }

        if($size == 1)
        {
            return $combinations;
        }

        $new_combinations = array();

        foreach($combinations as $combination)
        {
            foreach($chars as $char)
            {
                $new_combinations[] = $combination . $char;
            }
        }

        return $this->letsDo($chars, $size-1, $new_combinations);
    }

    protected function probe($userName, $password)
    {
        $result = false;
        $data = array(
            'username' => $userName,
            'password' => $password
        );

        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );

        $context = stream_context_create($options);
        $stream = fopen($this->_url, "r", FALSE, $context);
        $content = stream_get_contents($stream);
        if(strpos($content, $this->_successLoginTest) === FALSE)
        {
            $result = 'Success Login with: ' . $userName . ' / ' . $password . PHP_EOL;
        }

        fclose($stream);

        return $result;
    }

    public function guessWithBruteForce($userName)
    {
        foreach ($this->_combinations as $password)
        {
            $guessed = $this->probe($userName, $password);

            if($guessed)
            {
                echo $guessed . PHP_EOL;
                break;
            }
        }
    }

    public function guessWithDictionary($file)
    {
        try
        {
            $file = new SplFileObject($file);
        }
        catch(LogicException $e)
        {
            die($e->getMessage());
        }

        while ($file->valid())
        {
            $items = $file->fgetcsv(';');

            if(isset($items[0]) && isset($items[1]))
            {
                $guessed = $this->probe($items[0], $items[1]);

                if($guessed)
                {
                    echo $guessed . PHP_EOL;
                    die;
                }
            }
        }

        $file = null;
    }

    public function setSuccessLoginTest($value)
    {
        $this->_successLoginTest = $value;
    }
}