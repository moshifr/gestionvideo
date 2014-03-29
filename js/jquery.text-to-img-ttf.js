/*
 * PLUGIN - VAN HORDE Thomas
 * 
 * Remplace le text en image avec une typo perso
 * 
 * 
 * PARAMS :
 * 	color = Couleur d'affichage du texte
 * 	backgroundRGB = Couleur d'arrière plan, utile pour la transparence
 * 	folder = dossier de polices
 * 	font = police utilisé (TTF/OTF)
 * 	size = taille de police
 * 	justify = justifier 0 à 2
 * 
 * 
 * 	UTILISATION 
 * 
 * 	$('.valider').textToImage({
		size:"25", 
		color:"255,255,255",
		backgroundRGB:"109,21,107",
		font:"CaviarDreams.ttf"
	});
	
	
	OU
	
	
	<span size="30" justify="0" color="255,255,255" backgroundRGB="141,28,140" font="jellyka_cuttycupcakes.ttf" class="toimg">
		text
	</span>
	
	$('.toimg').textToImage();
 * 
 * 
 * 
 */

(function($) {
        // définition du plugin jQuery
        $.fn.textToImage = function(params) {
                // Fusionner les paramètres par défaut et ceux de l'utilisateur
                params = $.extend( {
                	justify: 0, 
                	color: '0,0,0', 
                	backgroundRGB: '0xFF,0xFF,0xFF', 
                	folder: 'font/', 
                	font: 'jellyka_cuttycupcakes.ttf', 
                	border: null, 
                	shadow: null, 
                	size: 46
                }, params);
                // Traverser tous les nœuds.
                this.each(function() {
                        // Exprimer un nœud seul en objet jQuery
                        var $element = $(this);
                        
                        // récupérer les infos
                        var surch_font = $element.attr('font');
                        var surch_size = $element.attr('size');
                        var surch_backgroundRGB = $element.attr('backgroundRGB');
                        var surch_color = $element.attr('color');
                        var surch_justify = $element.attr('justify');
                        var surch_border = $element.attr('border');
                        var surch_shadow = $element.attr('shadow');
                        
                        
                        // Traite les infos
                        if(surch_font != undefined)
                        	font = surch_font;
                        else
                        	font = params.font
                        	
                        	
	                    if(surch_border != undefined)
	                    	border = surch_border;
	                    else
	                    	border = params.border
	                    if(surch_shadow != undefined)
	                    	shadow = surch_shadow;
	                     else
	                    	shadow = params.shadow
                        	
                        	
                        	
                        if(surch_size != undefined)
                            size = surch_size;
                         else
                            size = params.size;
                        
                        if(surch_backgroundRGB != undefined)
                        	backgroundRGB = surch_backgroundRGB;
                        else
                        	backgroundRGB = params.backgroundRGB;

                        if(surch_justify != undefined)
                        	justify = surch_justify;
                        else
                        	justify = params.justify;

                        if(surch_color != undefined)
                        	color = surch_color;
                        else
                        	color = params.color;

                        font = params.folder + font;
                        
                        // récupérer le texte
                        var origText = $element.text();
                        
                        // Creation de l'url
                        img_url = 'geneTxt.php?text='+origText+'&font='+font+'&size='+size+'&backgroundRGB='+backgroundRGB+'&color='+color+'&justify='+justify;
                        
                        if(border != null)
                        	img_url += '&border='+border;
                        
                        if(shadow != null)
                        	img_url += '&shadow='+shadow;
                        
                        $.ajax({
                        	  url: img_url,
                        	  success: function(data) {                       	    
                                return_html = '<img style="border:none;" class="textToImage" alt="'+origText+'" src="'+data+'" /><span style="display:none">'+origText+'</span>';

                                $element.html(return_html);

                        	  }
                        	});                        
                        
                        
                });
        // Permettre le chaînage par jQuery
        return this;
        };
})(jQuery);