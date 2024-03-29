


# OTP 

Anlık SMS gönderimlerinde (şifre, onay kodu vs.) OTP Servisini kullanabilirsiniz.
SMS'lerde zaman ayarı yapılamaz, 3 dakika içerisinde iletilir.
## İçindekiler
- [İletişim & Destek](#i̇letişim--destek)
- [Doküman](#doküman)
- [Supported](#Supported-Laravel-Versions)
- [Kurulum](#kurulum)
- [Örnek](#örnek)
# İletişim & Destek

 Netgsm API Servisi ile alakalı tüm sorularınızı ve önerilerinizi teknikdestek@netgsm.com.tr adresine iletebilirsiniz.


# Doküman 
https://www.netgsm.com.tr/dokuman/
 API Servisi için hazırlanmış kapsamlı dokümana ve farklı yazılım dillerinde örnek amaçlı hazırlanmış örnek kodlamalara 
 [https://www.netgsm.com.tr/dokuman](https://www.netgsm.com.tr/dokuman) adresinden ulaşabilirsiniz.



### Supported Laravel Versions

Laravel 6.x, Laravel 7.x, Laravel 8.x, Laravel 9.x, 

### Supported Lumen Versions

Lumen 6.x, Lumen 7.x, Lumen 8.x, Lumen 9.x, 

### Supported Symfony Versions

Symfony 4.x, Symfony 5.x, Symfony 6.x

### Supported Php Versions

PHP 7.2.5 ve üzeri

### Kurulum

<b>composer require netgsm/otp </b>

.env  dosyası içerisinde NETGSM ABONELİK bilgileriniz tanımlanması zorunludur.  

<b>NETGSM_USERCODE=""</b>  
<b>NETGSM_PASSWORD=""</b>  
<b>NETGSM_HEADER=""</b>  


## ÖRNEK

```php     
        use Netgsm\Otp\otp;
         $data=array('message'=>'test mesajı5','no'=>'553XXXXXXX','header'=>'MESAJ_BASLIGINIZ');
        //header: isteğe bağlı olarak farklı header bilginizi girebilirsiniz. Default olarak .env dosyası  içerisinde belirtmiş olduğunuz header baz alınır.
        $islem=new otp;
        $sonuc=$islem->otp($data);
        dd($sonuc);
        
```

#### Başarılı istek örnek sonuç

```php
Array
(
    [durum] => Gönderim başarılı.
    [jobid] => 1310546758
)

```

#### Başarısız istek örnek sonuç

```php
Array
(
    [durum] => Gönderici adınızı kontrol ediniz.
    [code] => 41
)

```
