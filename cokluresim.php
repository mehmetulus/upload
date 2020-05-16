<?php
public function uploadMulti($nesnename,$tablo='nan',$KID=1,$yuklenecekyer='images/',$tur='img',$w='',$h='',$resimyazisi='')
	{
		if($tur=="img")
		{
			if(!empty($_FILES[$nesnename]["name"][0]))
			{
				$dosyanizinadi=$_FILES[$nesnename]["name"][0];
				$tmp_name=$_FILES[$nesnename]["tmp_name"][0];
				$uzanti=$this->uzanti($dosyanizinadi);
				if($uzanti=="png" || $uzanti=="jpg" || $uzanti=="jpeg" || $uzanti=="gif")
				{
					$resimler = array();
					foreach ($_FILES[$nesnename] as $k => $l) {
					  foreach ($l as $i => $v) {
						if (!array_key_exists($i, $resimler))
						  $resimler[$i] = array();
						$resimler[$i][$k] = $v;
					  }
					}
					
					foreach ($resimler as $resim){
						$uzanti=$this->uzanti($resim["name"]);
						if($uzanti=="png" || $uzanti=="jpg" || $uzanti=="jpeg" || $uzanti=="gif")
						{
							$handle = new Upload($resim);
	if ($handle->uploaded) {
		
		/* Resmi Yeniden Adlandır */
		$rand=uniqid(true);
		$handle->file_new_name_body = $rand;
		
		/* Resmi Yeniden Boyutlandır */
						if(!empty($w))
						{
							if(!empty($h))
							{
								
									$handle->image_resize = true;
								$handle->image_x = $w;
								$handle->image_y = $h;
								
							}
							else
							{
								if($handle->image_src_x>$w)
								{
									$handle->image_resize = true;
									$handle->image_x = $w;
									$handle->image_ratio_y = true;
								}
							}
						}
						else if(!empty($h))
						{
							if($handle->image_src_h>$h)
							{
								$handle->image_resize = true;
								$handle->image_y = $h;
								$handle->image_ratio_x = true;
							}
						}
		
		//üzerine yazı yazdırma
		if(!empty($resimyazisi))
		{
							$handle->image_text   = $resimyazisi;
						$handle->image_text_color      = '#FFFFFF';
						$handle->image_text_opacity    = 80;
						//$handle->image_text_background = '#FFFFFF';
						$handle->image_text_background_opacity = 70;
						$handle->image_text_font       = 5;
						$handle->image_text_padding    = 1;
		}
			
			
		/* Resim Yükleme İzni */
		$handle->allowed = array('image/*');
		
		/* Resmi İşle */
		//$handle->Process(realpath("../")."/upload/resim/");
		$handle->Process($yuklenecekyer);
		if ($handle->processed) {
		      $yukleme=$rand.".".$handle->image_src_type;
			  if(!empty($yukleme))
				{
					//$yuklemekontrol=$fnk->DKontrol("../images/resimler/".$yukleme);
					$sira=$this->IDGetir("resimler");
					
					$sql=$this->SorguCalistir("INSERT INTO resimler","SET tablo=?, KID=?, resim=?, tarih=?",array($tablo,$KID,$yukleme,date("Y-m-d")));
					
					
				}
				else
				{
					 return false;
				}
				
		} else {
                   return false;
		}

		$handle-> Clean();

	} else {
		return false;
	}
					
					
						}
					}
					return true;
					
					
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
?>
