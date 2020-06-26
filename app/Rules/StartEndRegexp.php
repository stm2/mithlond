<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class StartEndRegexp implements Rule
{

    private $rule;

    private $start_regexp;

    private $end_regexp;

    private $regexps;

    private $message;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(array $rule)
    {
        $this->rule = $rule;
        $this->start_regexp = '/^' . $rule['start']['regexp'] . '$/' . (isset($rule['start']['options']) ? $rule['start']['options'] : '');
        $this->end_regexp = '/^' . $rule['end']['regexp'] . '$/' . (isset($rule['end']['options']) ? $rule['end']['options'] : '');
        $this->regexps = $rule['regexps'];
        foreach ($this->regexps as $key => $r) {
            $this->regexps[$key] = '/^' . $r['regexp'] . '$/' . (isset($r['options']) ? $r['options'] : '');
        }
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
        $this->message = "";
        $lines = preg_split('/[\r]?[\n]/', $value);
        foreach ($lines as $lnr => $line) {
            if ($lnr == 0) {
                if (! preg_match($this->start_regexp, $line)) {
                    $this->message = 'orders should start with ' . $this->rule['start']['regexp'] . ', found ' . $line;
                    break;
                }
            } else if ($lnr + 1 == count($lines)) {
                if (! preg_match($this->end_regexp, $line)) {
                    $this->message = 'orders should end with ' . $this->rule['end']['regexp'] . ', found ' . $line;
                    break;
                }
            } else {
                $matched = - 1;
                foreach ($this->regexps as $rnr => $regexp) {
                    if (preg_match($regexp, $line)) {
                        $matched = $rnr;
                        break;
                    }
                }
                if ($matched < 0) {
                    $this->message = "line  " . ($lnr + 1) . " is not a valid order: '$line'";
                    break;
                }
            }
        }
        return empty($this->message);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
