


# OTP 

Anlık SMS gönderimlerinde (şifre, onay kodu vs.) OTP Servisini kullanabilirsiniz.
SMS'lerde zaman ayarı yapılamaz, 3 dakika içerisinde iletilir.

### Supported Laravel Versions

Laravel 6.x, Laravel 7.x, Laravel 8.x, Laravel 9.x, 

### Supported Php Versions

PHP 7.2.5 ve üzeri

### Kurulum

composer require netgsm/otp 

.env  dosyası içerisinde NETGSM ABONELİK bilgileriniz tanımlanması zorunludur.  

<b>NETGSM_USERCODE=""</b>  
<b>NETGSM_PASSWORD=""</b>  
<b>NETGSM_HEADER=""</b>  



```
        use Netgsm\Otp\otp;
    	$data['message']='test mesajı';
        $data['no']='xxxxxxxxxx';
        //$data['header']='xxxxxxxx';
        $islem=new otp;
        $sonuc=$islem->otp($data);
        echo '<pre>';
                print_r($sonuc);
        echo '<pre>';
```


