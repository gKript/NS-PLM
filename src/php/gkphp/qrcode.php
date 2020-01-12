 <?php

class QRCode {
  
  //tipo di chart
  private static $_CHT = "qr"; 
  
  //url della Google Chart Api
  private static $_API_URL = "http://chart.apis.google.com/chart";


	public function getQrCodeUrl($data,$width,$height,$encoding=false,$correctionLevel=false) {
		
		//faccio encoding dei dati
		$data = urlencode($data);
		
		//creo la url con i parametri obbligatori
		$url = QRCode::$_API_URL . "?cht=". QRCode::$_CHT
								 . "&chl=" . $data
								 . "&chs=" . $width . "x" . $height;

		//controllo i parametri opzionali
		if($encoding){
			$url .= "&choe=" . $encoding;
		}
		
		if($correctionLevel){
			$url .= "&chld=" . $correctionLevel;
		}
		
		return $url;
	}

}

?>