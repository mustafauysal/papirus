<?php
/**
 * @package Papirus
 * @author ysfkc
 * @author mustafauysal
 * @link https://github.com/egolabs/papirus
 */
class Papirus_Validation {
    /**
     * POST ve GET değerini içerir.
     * @var array
     */
    private $var;
    private static $instance;
 
    /**
     * Rolleri Barındırır.
     * @var array
     */
    private $rules = array();
 
    /**
     * Hatalı rulleri gösterir.
     * @var array
     */
    private $error = array();
 
    /**
     * @param array $var
     */
    private  function __construct(array $var)
    {
        $this->var = $var;
    }
 
    /**
     * @static
     * @param array $var
     * @return Form_Validation
     */
    public static function factory(array $var)
    {
        return new Papirus_Validation($var);
    }
 
    /**
     * Form kontrol kuralları tanımlanır.
     * @param $key dizi içindeki key adı
     * @param $rule kontrol kuralları
     * @return Form_Validation
     */
    public function rule($key, $rule)
    {
        $this->rules[$key] = $rule;
        return $this;
    }
 
    /**
     * Verilen anahtarın ( key ) dizi içinde olup olmadığı kontrolünü yapar.
     * @param $key dizi içindeki key adı
     * @return bool
     */
    private function required($key)
    {
        $val = trim($this->var[$key]);

        if (empty($val)) {
            return false;
        }

        return true;
    }
 
    /**
     * Verilen anahtarın ( key ) boş/doluluk kontrolünü yapar.
     * @param $key dizi içindeki key adı
     * @return bool
     */
    private function not_empty($key)
    {
        if (!isset($this->var[$key])) {
            return false;
        }
        $val = trim($this->var[$key]);
        return empty($val) !== true;
    }
 
    /**
     * Girilen e-mail adresinin geçerliliğini kontrol eder.
     * @param $key dizi içindeki key adı
     * @return bool
     */
    private function valid_email($key)
    {
      //$sanitize_email = filter_var($this->var[$key], FILTER_SANITIZE_EMAIL);
 
        if (filter_var($this->var[$key], FILTER_VALIDATE_EMAIL) === false) {
            return false;
        }
 
        return true;
    }
 
    /**
     * Girilen ip adresinin geçerliliğini kontrol eder.
     * @param $key dizi içindeki key adı
     * @return bool
     */
    private function is_ip($key)
    {
        if (filter_var($this->var[$key], FILTER_VALIDATE_IP) === false) {
            return false;
        }
 
        return true;
    }
 
    /*
     * Girilen değerin minimum değerden küçük olup olmadığını kontrol eder.
     */
    private function min($val,$min) {
        if ($val < $min) {
            return false;
        }
        return true;
    }
 
    /*
     * Girilen değerin minimum değerden büyük olup olmadığını kontrol eder.
     */
    private function max($val,$min) {
        if ($val > $min) {
            return false;
        }
        return true;
    }
 
    /**
     * Girilen değerin numeric olup olmadığını kontrol eder.
     * @param $key dizi içindeki key adı
     * @return bool
     */
    private function is_int($key)
    {
        if (filter_var($this->var[$key], FILTER_VALIDATE_INT) === false) {
            return false;
        }
 
        return true;
    }
 
    /**
     * Girilen değerin string olup olmadığını kontrol eder.
     * @param $key dizi içindeki key adı
     * @return bool
     */
    private function is_string($key)
    {
        return is_string($this->var[$key]);
    }
 
    /**
     * Değerin minimum uzunluğunu kontrol eder.
     * @param $key dizi içindeki key adı
     * @param $len uzunluk değeri
     * @return bool
     */
    private function min_len($key,$len)
    {
        return (mb_strlen($this->var[$key]) >= $len);
    }
 
    /**
     * Değerin maximum uzunluğunu kontrol eder.
     * @param $key dizi içindeki key adı
     * @param $len uzunluk değeri
     * @return bool
     */
    private function max_len($key,$len)
    {
        return (mb_strlen($this->var[$key]) <= $len);
    }
 
    /**
     * Girilen url adresinin geçerliliğini kontrol eder.
     * @param $key dizi içindeki key adı
     * @return bool
     */
    private function valid_url($key)
    {
        $sanitize_url = filter_var($this->var[$key], FILTER_SANITIZE_URL);
 
        if (filter_var($sanitize_url, FILTER_VALIDATE_URL) === false) {
            return false;
        }
 
        return true;
    }
 
    /**
     * Girilen tarihin geçerliliğini kontrol eder.
     * @param $key dizi içindeki key adı
     * @return bool
     */
    private function valid_date($key)
    {
        return strtotime($this->var[$key]) == true;
    }
 
    /**
     * Girilen telefon numarasının doğruluğunu kontrol eder.
     * @param $key
     * @return bool
     */
    private function phone($key)
    {
        $len = array(10,11,13,14);
 
        $num = preg_replace('#\d+#','',$this->var[$key]);
 
        return in_array(strlen($num), $len);
    }
 
    /**
     * FILES dizinin boş olup olmadığını kontrol eder.
     * @param $key
     * @return bool
     */
    public function not_empty_file($key)
    {
        return empty($_FILES[$key]['name']) !== true;
    }
 
    /**
     * Belirtilen kuralları kontrol eden fonksiyon.
     * @throws Exception
     * @return bool
     */
    public function check()
    {
        try
        {
            $is_valid = true;
 
            if (empty($this->var)) {
                return false;
            }
 
            if (empty($this->rules)) {
                return true;
            }
 
            foreach ($this->rules AS $key => $val) {
 
                $rules = explode('|', $val);
 
                foreach ($rules AS $rule) {
 
                    if (!strstr($rule,'max') && !strstr($rule, 'min')) {
 
                        if (is_callable(array($this, $rule)) === false) {
                            throw new Exception(__CLASS__.' <b>'.$rule.'</b> Call to undefined method');
                        }
 
                        $is_valid = $this->$rule($key);
                        if (!$is_valid) {
                            $this->error[$key] = $rule.' hatalı';
                        }
 
                    } else {
                        $rule = explode(':', $rule);
 
                        if (is_callable(array($this, $rule[0])) === false) {
                            throw new Exception(__CLASS__.' <b>'.$rule[0].'</b> Call to undefined method');
                        }
 
                        $is_valid = $this->$rule[0]($key, $rule[1]);
                        if (!$is_valid) {
                            $this->error[$key] = $rule[0].' hatalı';
                        }
                    }
                }
            }
 
            if (count($this->error) > 0) {
                return false;
            }
 
            return $is_valid;
        } Catch (Exception $e) {
            echo '<pre>'.var_export($e,true).'</pre>';
        }
    }
 
    /**
     * Hata Mesajlarını Döndürür.
     * @return array
     */
    public function getErrors()
    {
        return $this->error;
    }
}

