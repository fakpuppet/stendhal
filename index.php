<?php
	session_start();
	
	$_SESSION["language"]="sr";
	
	if (isset($_GET["lang"]))
	{ 
		$_SESSION["language"] = strtolower($_GET["lang"]);
	}
	else
	{
		$_SESSION["language"] = "sr";
	}
	
	function dirList ($directory)
	{
		$files = rglob($directory, "*.jpg", null);
		
		foreach($files as $file)
		{
			echo("<li><a href='".str_replace("/thumbnails", "", $file)."'><img src='$file' /></a></li>");
		}
	}
	
	function dirImages ($directory)
	{
		$files = rglob($directory, "*.[jJ][pP][gG]", null);
		
		foreach($files as $file)
		{
			echo("<img src='$file' /></a>");
		}
	}
	
	function getPanelContent($panelid, $language)
	{
		if (file_exists("pages/".$panelid."_".$language.".php")){
			include_once("pages/".$panelid."_".$language.".php");
		}
		else
		{
			echo '<p align="center"><h2>NA ZALOST STRANICA NIJE PRONADJENA!<br>TO MU DODJE NEKI ERROR 404</h2>';
		}
	}
			
	function rglob($sDir, $sPattern, $nFlags = NULL)
	{
		// $sDir = escapeshellarg($sDir);
		
		$aFiles = glob("$sDir/$sPattern", $nFlags);
		return $aFiles;
	}  

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
<meta name="keywords" content="moda, modeli, foto-modeli, Stendhal, modna agencija, kurs mode, kurs za foto-modele, visoka moda, novi sad"
<title>Umetnički studio "Stendhal"</title>

<link rel="stylesheet" href="styles/stendhal.css" type="text/css" media="screen" title="no title" charset="utf-8"/>
<link rel="stylesheet" href="styles/lightbox.css" type="text/css" media="screen" title="no title" charset="utf-8"/>
<link rel="icon" href="pictures/favicon.png" type="image/png" />
<!-- <link rel="SHORTCUT ICON" href="/nekaslika.ico" /> -->

<!-- JQuery Generalni importi -->
<script src="scripts/jquery.js" type="text/javascript"></script>

<!-- Scroll pluginovi -->

<script src="scripts/jquery.scrollTo.js" type="text/javascript"></script>
<script src="scripts/jquery.localscroll.js" type="text/javascript"></script>
<script src="scripts/jquery.serialScroll.js" type="text/javascript"></script>
<script src="scripts/jquery.scrollinitiator.js" type="text/javascript"></script>
<script src="scripts/jquery.tools.min.js" type="text/javascript"></script>

<!-- LIGHTBOX -->

<script src="scripts/jquery.lightbox.min.js" type="text/javascript"></script>

<script type="text/javascript" charset="utf-8">

(function () {
	
    $.fn.infiniteCarousel = function () {
        function repeat(str, n) {
            return new Array( n + 1 ).join(str);
        }
        
        return this.each(function () {
            // magic!
            var $wrapper = $('> div', this).css('overflow', 'hidden'),
                $slider = $wrapper.find('> ul').width(9999),
                $items = $slider.find('> li'),
                $single = $items.filter(':first')
                
                singleWidth = $single.outerWidth(),
                visible = Math.ceil($wrapper.innerWidth() / singleWidth),
                currentPage = 1,
                pages = Math.ceil($items.length / visible);
                
            /* TASKS */
            
            // 1. pad the pages with empty element if required
            if ($items.length % visible != 0) {
                // pad
                $slider.append(repeat('<li class="empty" />', visible - ($items.length % visible)));
                $items = $slider.find('> li');
            }
            
            // 2. create the carousel padding on left and right (cloned)
            $items.filter(':first').before($items.slice(-visible).clone().addClass('cloned'));
            $items.filter(':last').after($items.slice(0, visible).clone().addClass('cloned'));
            $items = $slider.find('> li');
            
            // 3. reset scroll
            $wrapper.scrollLeft(singleWidth * visible);
            
            // 4. paging function
            function gotoPage(page) {
                var dir = page < currentPage ? -1 : 1,
                    n = Math.abs(currentPage - page),
                    left = singleWidth * dir * visible * n;
                
                $wrapper.filter(':not(:animated)').animate({
                    scrollLeft : '+=' + left
                }, 300, function () {
                    // if page == last page - then reset position
                    if (page > pages) {
                        $wrapper.scrollLeft(singleWidth * visible);
                        page = 1;
                    } else if (page == 0) {
                        page = pages;
                        $wrapper.scrollLeft(singleWidth * visible * pages);
                    }
                    
                    currentPage = page;
                });
            }
            
            // 5. insert the back and forward link
            $wrapper.before('<a href="#" class="arrow back"></a>');
            $wrapper.after('<a href="#" class="arrow forward"></a>');
            
            // 6. bind the back and forward links
            $('a.back', this).click(function () {
                gotoPage(currentPage - 1);
                return false;
            });
            
            $('a.forward', this).click(function () {
                gotoPage(currentPage + 1);
                return false;
            });
            
            $(this).bind('goto', function (event, page) {
                gotoPage(page);
            });
            
            // THIS IS NEW CODE FOR THE AUTOMATIC INFINITE CAROUSEL
            $(this).bind('next', function () {
                gotoPage(currentPage + 1);
            });
        });
    };
})(jQuery);

$(document).ready(function () {

	function(){
		$('#facebox').remove();
		$('#facebox_overlay').remove();
	}

    // THIS IS NEW CODE FOR THE AUTOMATIC INFINITE CAROUSEL
    var autoscrolling = true;
    
    $('.infiniteCarousel').infiniteCarousel().mouseover(function () {
        autoscrolling = false;
    }).mouseout(function () {
        autoscrolling = true;
    });
    
    setInterval(function () {
        if (autoscrolling) {
            $('.infiniteCarousel').trigger('next');
        }
    }, 6000);
    

	$(function() { 
	    $("a[rel]").overlay({expose: '#000', effect: 'apple'});
	});
	
	$(function() {
	    $('#gallery a').lightBox();
	});

});

</script>


<script>

</script>

</head>

<body>

<div id="backdrop">
	
</div>

<div id="navigation_top">

	<a href="<?php echo $_SERVER["PHP_SELF"]."?lang=sr"?>"class="srpski"></a>
	<a href="<?php echo $_SERVER["PHP_SELF"]."?lang=en"?>" class="english"></a>

</div>

<div id="superheader">
	<div id="fashionworld"></div>
</div>

<div id="carouseltop"></div>

<div id="content_wrapper">
        
    <div id="intro">
    	<!-- nista ovdi -->
    </div>
    
    <!-- TABOVI ZA NAVIGACIJU -->
    
    <!-- & MALO PHP-a...	  -->
    
    <?php
    if ($_SESSION["language"] == "en")
    {
    	$aboutus_tab = "ABOUT US";
    	$team_tab = "WHO ARE STENDHAL?";
    	$course_tab = "FASHION MODEL COURSE";
    	$partners_tab = "PARTNERS";
    	$contact_tab = "CONTACT";
    	$gallery_tab = "GALLERY";
    	$nowandthen_tab = "NOW AND THEN...";
    }
    else if ($_SESSION["language"] == "sr")
    {
    	$aboutus_tab = "O NAMA";
    	$team_tab = "KO ČINI STENDHAL?";
    	$course_tab = "KURS ZA MANEKENE";
    	$partners_tab = "PARTNERI";
    	$contact_tab = "KONTAKT";
    	$gallery_tab = "GALERIJA";
    	$nowandthen_tab = "NEKAD I SAD...";
    }
    ?>
    
    <div id="scrolltabs_wrapper">
        <ul class="scrolltabs">
            <li><a href="#onama"><?php echo $aboutus_tab; ?></a></li>
            <li><a href="#team"><?php echo $team_tab; ?></a></li>
            <li><a href="#kurs"><?php echo $course_tab; ?></a></li>
            <li><a href="#partneri"><?php echo $partners_tab; ?></a></li>
            <li><a href="#kontakt"><?php echo $contact_tab; ?></a></li>
            <li><a href="#nekadisad"><?php echo $nowandthen_tab; ?></a></li>
            <!-- <li><a href="#galerija"><?php echo $gallery_tab; ?></a></li> -->
        </ul>
    </div>        
    
    <div id="slider_wrapper">
    
    <!-- MODELI SA SVAKE STRANE SADRZAJA SAJTA -->
	<div id="leftside_model"></div>
 	<div id="rightside_model"></div>
   
    <div id="slider">
           
			<div class="scroll"> 
				
                <div class="scrollContainer">
                
                <!-- PANELI SA SADRZAJEM TABOVA -->
                
	                <div class="panel" id="onama">
		                <?php 
		                	getPanelContent("onama", $_SESSION["language"]);
						?>
					</div>
				
	                <div class="panel" id="team">
		                <?php
		                	getPanelContent("team", $_SESSION["language"]);
		                ?>
					</div>
				
	                <div class="panel" id="kurs">
		                <?php
		                	getPanelContent("kurs", $_SESSION["language"]);
		                ?>
            		</div>
            	
            	<div class="panel" id="partneri">
            		<h2><p align="center">PARTNERI STUDIJA STENDHAL<br><br></p></h2>
            		
            		<table cellpadding="15" cellspacing="15" align="center" class="partners">
            		<tr>
            		<td colspan="2"><a href="http://www.hotelparkns.com/" title="Hotel Park, Novi Sad"><img src="pictures/partneri/hotel_park_logo.png"></a></td>
            		<td colspan="2"><a href="http://www.prezidenthotel.com/" title="Hotel Prezident, Novi Sad"><img src="pictures/partneri/prezident_logo.png"></a></td>
            		</tr>
            		
            		<tr>
	            		<td><a href="http://www.hotelparkns.com" title="Hotel 'Aleksandar', Novi Sad"><img src="pictures/partneri/aleksandar_logo.png"></a></td>
						<td><img src="pictures/partneri/zlatara_siket_logo.png" title="Zlatara Šiket"></td>						
	            		<td><a href="http://www.divaclinic.com/" title="Poliklinika Diva"><img src="pictures/partneri/diva_logo.jpg"></a></td>
						<td><img src="pictures/partneri/elite_tours_logo.png" title="Turistička agencija 'Elite-Tours'"></td>
            		</tr>
					<tr>
						<td><a href="http://www.stingurbanstore.com/" title="Sting Urban Store"><img src="pictures/partneri/sting_logo.jpg"></a></td>
						<td><img src="pictures/partneri/yason_logo.png"></td>
						<td><img src="pictures/partneri/zlatara_sandol_logo.png"></td>
	            		<td><a href="http://www.ooops.co.rs/" title="Modna kuća 'OOOPS'"><img src="pictures/partneri/ooops_logo.png"></a></td>
					</tr>
            		</table>
            		
            	    <div class="partneri"><p class="smallcap">Modni studio "Mirjam" - modni kreator Mirjana Stanojević</p></div>
            	    <div class="partneri"><p class="smallcap">Modna kuća  </p></div>
            	    <div class="partneri"><p>Hotel "Aleksandar"  </p></div>
            	    
            	</div>
            	
            	<div class="panel" id="kontakt">
            		<h2><p>Za sve dodatne informacije možete nas kontaktirati:<br></p></h2>
            		<p>&nbsp</p>
            		<p><h2>E-mail: <a href="mailto:kontakt@stendhal.org.rs">kontakt@stendhal.org.rs</a></h2></p>
            		<p><h2>Telefon: +381 63 467 522</h2></p>
            	</div> 
            	           	
            	<div class="panel" id="nekadisad">
					<div id="nowAndThen">
						<div class="wrapper" id="gallerynis">
							<ul>
								<?php
									echo dirImages("nekadisad/thumbnails");
								?>
							</ul>
						</div>
					</div>
            	</div>
             	 
        	</div>
 
		</div>   
	     
</div>
</div>
<div id="wrappershadow"></div>
	
<div id="gallerycontainer">

	<div class="infiniteCarousel">
		<div class="wrapper" id="gallery">
			<ul>
				<?php
					echo dirList("slike/thumbnails");
				?>
			</ul>
		</div>
	</div>
	
</div>


<div id="footer">
	Umetnički studio "Stendhal", Novi Sad<br>
	Copyright © 2008-2010 | Dizajn baj <a href="http://www.cephalus.in.rs">CEPHALUS</a><br>
</div>

<!-- VIDEO KLIP MODNE REVIJE -->
<div class="overlay" id="video_stendhal">

<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/yxi7OFFoCq0&hl=en_US&fs=1&rel=0&color1=0x3a3a3a&color2=0x999999"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/yxi7OFFoCq0&hl=en_US&fs=1&rel=0&color1=0x3a3a3a&color2=0x999999" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385"></embed></object>

</div>

<!-- BIOGRAGIJE -->
<!-- MARKO SRPSKI -->
			
<div class="overlay" id="marko_bio_sr">
<div class="portret"><img src="avatars/marko_portret.png" class="avatar"/></div>
<div class="bio">
<p align="center"><span class="titula">Marko Jukić</span><br>ASISTENT STUDIJA<br><br></p>
<p align="justify">Svoj urođeni dar za glumu i ples pretočio u manekenstvo. Nesumnjivo jedan od najboljih manekena u Vojvodini. U svakoj reviji unese nešto novo i neobično. 

<br><br>

U nekoliko zadnjih kurseva bio pomoćnik-instruktor i pokazao da mu i to dobro ide. Želja mu je da ima svoj studio. Perspektivan i ambiciozan. Budućnost je pred njim i smeši se cinično...

<br><br></p>
<p align="center"><span class="moto">ŽIVOTNI MOTO NIJE STEKAO...</span></p></div>
</div>

<!-- MARKO ENGLESKI -->
			
<div class="overlay" id="marko_bio_en">
<div class="portret"><img src="avatars/marko_portret.png" class="avatar"/></div>
<div class="bio">
<p align="center"><span class="titula">Marko Jukić</span><br>STUDIO ASSISTANT<br><br></p>
<p align="justify">He poured his natural talent for acting and dance into fashion modelling. Undoubtedly one of the best male models in Vojvodina. Endows each and every fashion show with something fresh and unusual. 

<br><br>

In the last few fashion courses he acted as an assistant-instructor and showd that he does well in that role too. His great desire is to have a studio of his own. He's ambitious and very promising. The future before him shines particularly bright!

<br><br></p>
<p align="center"><span class="moto">ŽIVOTNI MOTO NIJE STEKAO...</span></p></div>
</div>

<!-- MAJA SRPSKI -->

<div class="overlay" id="maja_bio_sr">
<div class="portret"><img src="avatars/maja_portret.png" class="avatar"/></div>
<div class="bio"><p align="center"><span class="titula">Maja Furtula</span><br>ASISTENT STUDIJA<br><br></p>
<p align="justify">Od 2007. godine zaštitni znak studija “Stendhal”. Sve što je značajno za studio vezano je za njen lik. U jednom isečku vremena Saša ju je ovekovečio kao Madonu. Zanimljiva, čudne lepote, graciozna. Nosilac crnog pojasa u karateu.
<br><br>
Na pisti pleni ženstvenošću i lepotom pokreta. Sa njom i Markom “Stendhal” je bogatiji za jedno značajno iskustvo. Neka tako i ostane.
</p></div>
</div>

<!-- MAJA ENGLESKI -->

<div class="overlay" id="maja_bio_en">
<div class="portret"><img src="avatars/maja_portret.png" class="avatar"/></div>
<div class="bio"><p align="center"><span class="titula">Maja Furtula</span><br>STUDIO ASSISTANT<br><br></p>
<p align="justify">Since 2007. she's a trademark of 'Stendhal' studio. Everything that is important for the Studio is in a way connected to her. At one point in time she's been immortalized by Saša as Madonna. Intriguing, of peculiar beauty, gracious. Black belt holder in karate.
<br><br>
On the catwalk she mesmerizes by her Na pisti pleni ženstvenošću i lepotom pokreta. Sa njom i Markom “Stendhal” je bogatiji za jedno značajno iskustvo. Neka tako i ostane.
</p></div>
</div>

<!-- SASA SRPSKI -->
<div class="overlay" id="sasa_bio_sr">
<div class="portret"<img src="avatars/sasa_portret.png"/></div>
	
<div class="bio">
<p align="center"><span class="titula">Saša Đurđević</span></p><p align="center">ART-FOTOGRAF<br><br></p>
<p align="justify">
Veliki majstor umetničke fotografije. Za sve ove godine koje su obeležile uspešan rad Studija, veliki “krivac” za vizuelni dojam. Obeležio mnoge značajne događaje u razvoju Studija (revije, kursevi, spotovi...). 

<br><br>

Veliki zaljubljenik u fudbal sa Ostrva. Objektiv je njegova pasija a životni moto:

<br></p>
<p align="center"><span class="moto"><br>“ZA VELIKE STVARI TREBA IMATI DOBRO OKO”!</span></p></div>
</div>

<!-- SASA ENLEZKI -->
<div class="overlay" id="sasa_bio_en">
<div class="portret"<img src="avatars/sasa_portret.png"/></div>
	
<div class="bio">
<p align="center"><span class="titula">Saša Đurđević</span></p><p align="center">ART-PHOTOGRAPHER<br><br></p>
<p align="justify">
The Grand Master of artistic photography. Throughout the years of Studio's successful work he's largely been to "blaim" for the distinct visual impression. He marked many of the important events in the development of the Studio (shows, courses, videos,...). 

<br>

He's a great follower of the soccer from The Islands. The camera lense is his passion and his moto is:

<br></p>
<p align="center"><span class="moto"><br>“GREAT THINGS REQUIRE GREAT VISION”!</span></p></div>
</div>

<!-- ALEKSANDRA SRPSKI -->

<div class="overlay" id="aleksandra_bio_sr">
<div class="portret"><img src="avatars/aleksandra_portret.png"/></div>
<div class="bio">
<p align="center"><span class="titula">Aleksandra Bunčić</span><br>STILISTA I INSTRUKTOR STUDIJA<br><br></p>
<p align="justify">Zahvaljujući njoj u aprilu kreće i trinaesta generacija manekena i foto modela. 

Izuzetan instruktor na časovima, pažljiva, nenametljiva. Svoje bogato iskustvo od tri godine učenja manekenskog zanata na kursu prenosi nesebično na mlade generacije. U horoskopu - kao i životu - riba.<br><br></p>

<p align="center">Njena deviza:<br><span class="moto"> 
“NE TREBA ŽURITI, UVEK SE STIGNE NA VREME”!</span>
</p></div>
</div>

<!-- ALEKSANDRA ENGLESKI -->

<div class="overlay" id="aleksandra_bio_en">
<div class="portret"><img src="avatars/aleksandra_portret.png"/></div>
<div class="bio">
<p align="center"><span class="titula">Aleksandra Bunčić</span><br>STYLIST AND STUDIO INSTRUCTOR<br><br></p>
<p align="justify">Thanks to her April will see the 13th generation of fashion models. 

Exceptional fashion instructor, caring, unimposing. Her rich experience is passed on to the younger generations selfleslly.

<br> Her horoscope sign - pisces.<br><br></p>

<p align="center"><span class="moto">Her moto:<br> 
“THERE IS NO NEED TO RUSH, YOU ALWAYS GET WHERE YOU NEED TO BE ON TIME”!</span>
</p></div>
</div>

<!-- ZIS SRPSKI -->

<div class="overlay" id="zis_bio_sr">
<div class="portret"><img src="avatars/zis_portret.png"/></div>
<div class="bio">
<p align="center"><span class="titula">Svetislav-Bata Petrović</span><br>MENADŽER STUDIJA<br><br></p>
<p align="justify">Ex Profesor Ex Yu književnosti, pisac i rock pevač (frontmen benda ‘Prognanik Lu’). Avanturist duha i mistik. U horoskopu i životu LAV. Smatra da je moda vid umetnosti. Tako joj i pristupa, netipično i originalno.

<br><br>

Neizlečivo zaljubljen u sedamdesete zbog čega je bio i lečen na više prestižnih klinika u zemlji i inostranstvu.<br><br>
</p>
<p align="center"><span class="moto">Životni moto:<br>“LEPOTA ĆE SPASITI SVET”!</span>
</p>
</div>
</div>

<!-- ZIS ENGLESKI -->

<div class="overlay" id="zis_bio_en">
<div class="portret"><img src="avatars/zis_portret.png"/></div>
<div class="bio">
<p align="center"><span class="titula">Svetislav-Bata Petrović</span><br>MENADŽER STUDIJA<br><br></p>
<p align="justify">Ex Professor of Ex-Yu literature, writer and rock singer (frontman of ‘Prognanik Lu’ band). Adventurist of the mind and a mystic. Lion in both life and horoscope. Sees fashion as a form of art. He acts about it accordingly - atypically and originally.

<br>

Incurably in love with the seventies for which he sought treatment at several prestigious clinics, domestic and abroad.<br>
</p>
<p align="center"><span class="moto">Life's moto:<br>“BEAUTY WILL SAVE THE WORLD”!</span>
</p>
</div>
</div>

</body>
</html>