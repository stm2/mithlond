<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ComposedRegexp implements Rule
{

    private $regexp;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(array $rule)
    {
        $regexp = "";
        foreach ($rule['replacers'] as $replacer) {
            if ($regexp == '') {
                if ($replacer['from'] != '')
                    throw new \Exception('invalid first order validation rule');
                else
                    $regexp = $replacer['to'];
            } else {
                if (isset($replacer['join'])) {
                    $replace = "";
                    foreach ($replacer['to'] as $part) {
                        if (strlen($replace) > 0)
                            $replace .= '|';
                        $replace .= '(' . $part . ')';
                    }
                } else {
                    $replace = $replacer['to'];
                }
                $regexp = str_replace($replacer['from'], '(' . $replace . ')', $regexp);
            }
        }
        $regexp = "{^" . $regexp . "$}i";
        // $this->pretty_print($regexp);
        $this->regexp = $regexp;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match($this->regexp, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute is an invalid submission.';
    }

    private function pretty_print(String $exp)
    {
        $stack = [];
        $match = [
            '(' => ')',
            '[' => ']',
            '{' => '}'
        ];
        $maxlength = 20;
        $state = 0;
        $line = "";
        for ($i = 0; $i < strlen($exp); ++ $i) {
            if (preg_match("{[\{\(\[]}", $exp[$i])) {
                if (strlen($line) > 0) {
                    echo "\n";
                    for ($j = 0; $j < count($stack); ++ $j)
                        echo "  ";
                    echo $line;
                }
                echo "\n";
                for ($j = 0; $j < count($stack); ++ $j)
                    echo "  ";
                $stack[] = $exp[$i];
                echo $exp[$i];
                $laststate = $state;
                $state = - 1;
                $line = "";
            } else if (preg_match("{[\}\)\]]}", $exp[$i])) {
                $pop = array_splice($stack, - 1);
                $warn = "";
                if ($match[$pop[0]] != $exp[$i]) {
                    $stack[] = $pop[0];
                    $warn = "!!";
                }
                $newline = strlen($line) > $maxlength || strlen($warn) > 0 || $state == - 2 || $laststate != - 1;
                if (strlen($line) > 0) {
                    if ($newline) {
                        echo "\n";
                        for ($j = - 1 + strlen($warn) / 2; $j < count($stack); ++ $j)
                            echo "  ";
                        echo "$line";
                    } else {
                        echo $line;
                    }
                }
                if ($newline) {
                    echo " \n$warn";
                    for ($j = 0 + strlen($warn) / 2; $j < count($stack); ++ $j)
                        echo "  ";
                }
                echo $exp[$i];
                $laststate = $state;
                $state = - 2;
                $line = "";
            } else {
                if ($state < 0) {
                    $laststate = $state;
                    $state = 0;
                    $line = "";
                }
                $line .= $exp[$i];
                ++ $state;
            }
        }
        foreach ($stack as $par) {
            echo "\n!!! $par\n";
        }
        if (strlen($line) > 0)
            echo "$line\n";
    }
}
