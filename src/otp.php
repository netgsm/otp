<?php

namespace Netgsm\Otp;

use Exception;
use Ramsey\Uuid\Type\Integer;
use SimpleXMLElement;

class otp
{   
   
    private $username;
    private $password;
    private $header;
    public function __construct()
    {
     if(isset($_ENV['NETGSM_USERCODE']))
      {
          $this->username=$_ENV['NETGSM_USERCODE'];
      }
      else{
          $this->username='x';
      }
      if(isset($_ENV['NETGSM_PASSWORD']))
      {
          $this->password=$_ENV['NETGSM_PASSWORD'];
      }
      else{
          $this->password='x';
      }
      if(isset($_ENV['NETGSM_HEADER']))
      {
          $this->header=$_ENV['NETGSM_HEADER'];
      }
      else{
          $this->header='x';
      }
        
    }
    
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
            $header=$this->header;
           
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
               <usercode>'.$this->username.'</usercode>
               <password>'.$this->password.'</password>
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
            30=>'Ge??ersiz kullan??c?? ad?? , ??ifre veya kullan??c??n??z??n API eri??im izninin olmad??????n?? g??sterir.Ayr??ca e??er API eri??iminizde IP s??n??rlamas?? yapt??ysan??z ve s??n??rlad??????n??z ip d??????nda g??nderim sa??l??yorsan??z 30 hata kodunu al??rs??n??z. API eri??im izninizi veya IP s??n??rlaman??z?? , web aray??zden; sa?? ??st k????ede bulunan ayarlar> API i??lemleri men??sunden kontrol edebilirsiniz.',
            40=>'G??nderici ad??n??z?? kontrol ediniz.',
            41=>'G??nderici ad??n??z?? kontrol ediniz.',
            50=>'G??nderilen numaray?? kontrol ediniz.',
            60=>'Hesab??n??zda OTP SMS Paketi tan??ml?? de??ildir, kontrol ediniz.',
            70=>'	Input parametrelerini kontrol ediniz.',
            80=>'Sorgulama s??n??r a????m??.(dakikada 100 adet g??nderim yap??labilir.)',
            100=>'Sistem hatas??.',
            
            );
            $donen = new SimpleXMLElement($result);

            $code=strval($donen->main->code);
            
            if($code==20||$code==30||$code==40||$code==41||$code==50||$code==60||$code==70||$code==80||$code==100)
            {
                $response["durum"]=$sonuc[$code];
                $response["code"]=$code;
            }
            else{
                $response["durum"]='G??nderim ba??ar??l??.';
                
                $jobid=strval(($donen->main->jobID[0]));
                $response["jobid"]=$jobid;
            }

           
        
        
        return $response;
    }
}