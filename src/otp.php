<?php

namespace Netgsm\Otp;

use Exception;
use Ramsey\Uuid\Type\Integer;
use SimpleXMLElement;

class otp
{   
   
    
    public function otp($data):array
    {
        if(!isset($data['message'])){
            
            $response['durum']='message giriniz';
            return $response;
        }
        
        if(!isset($data['no'])){
            $response['durum']='Numara giriniz';
            return $response;
        }
        if(!isset($data['header'])){
            $header=env("NETGSM_HEADER");
           
        }
        else{
            $header=$data['header'];
        }
        if(empty($header))
        {
             $response['message']='header bilgisini kontrol ediniz.';
             return $response;
        }
        $xmlData='<?xml version="1.0"?>
        <mainbody>
           <header>
               <usercode>'.env("NETGSM_USERCODE").'</usercode>
               <password>'.env("NETGSM_PASSWORD").'</password>
               <msgheader>'.$header.'</msgheader>
           </header>
           <body>
               <msg>
                   <![CDATA['.$data['message'].']]>
               </msg>
               <no>'.$data['no'].'</no>
           </body>
        </mainbody>';
        $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,'https://api.netgsm.com.tr/sms/send/otp');
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,2);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlData);
		$result = curl_exec($ch);
       
		
        
        $sonuc=array(
            20=>'Mesaj metni ya da mesaj boyunu kontrol ediniz.',
            30=>'Geçersiz kullanıcı adı , şifre veya kullanıcınızın API erişim izninin olmadığını gösterir.Ayrıca eğer API erişiminizde IP sınırlaması yaptıysanız ve sınırladığınız ip dışında gönderim sağlıyorsanız 30 hata kodunu alırsınız. API erişim izninizi veya IP sınırlamanızı , web arayüzden; sağ üst köşede bulunan ayarlar> API işlemleri menüsunden kontrol edebilirsiniz.',
            40=>'Gönderici adınızı kontrol ediniz.',
            41=>'Gönderici adınızı kontrol ediniz.',
            50=>'Gönderilen numarayı kontrol ediniz.',
            60=>'Hesabınızda OTP SMS Paketi tanımlı değildir, kontrol ediniz.',
            70=>'	Input parametrelerini kontrol ediniz.',
            80=>'Sorgulama sınır aşımı.(dakikada 100 adet gönderim yapılabilir.)',
            100=>'Sistem hatası.',
            
            );
            $donen = new SimpleXMLElement($result);

            $code=strval($donen->main->code);
            
            if($code==20||$code==30||$code==40||$code==41||$code==50||$code==60||$code==70||$code==80||$code==100)
            {
                $response["durum"]=$sonuc[$code];
                $response["code"]=$code;
            }
            else{
                $response["durum"]='Gönderim başarılı.';
                
                $jobid=strval(($donen->main->jobID[0]));
                $response["jobid"]=$jobid;
            }

           
        
        
        return $response;
    }
}