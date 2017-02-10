$(function(){
    	console.log("jquery actif");
    	
		$(".supprimer-comment").click(function(){
			console.log("suppression com demandée");
			var myButton = $(this);
			var trButton = myButton.parent().parent();
			var monId = $(this).attr('data-button');
			var monIdSig = $(this).attr('data-sig');
			console.log("monId : "+monId);
			var monUrl = "{{ path('delCommentAdmin',{'id': 'monId', 'idSig': 'monIdSig'}) }}";
			monUrl = monUrl.replace('monId',monId);
			monUrl = monUrl.replace('monIdSig',monIdSig);
			console.log("MonUrl : "+monUrl);
			$.ajax({
				url : monUrl ,
				dataType: "json" 				
				}).done(function(){
					// en cas de succès
					console.log("commentaire supprimé");
					// faire disparaitre la ligne
					trButton.hide();
				}
			).fail(function(err){
				// ('Echec ajax');
				console.log("échec ajax");			
			});
		});
		

		

		$(".ignorer-comment , .ignorer-decrypt").click(function(){
			console.log("ignorer com demandé");
			var myButton = $(this);
			var trButton = myButton.parent().parent();
			var monId = $(this).attr('data-button');
			console.log("monId : "+monId);
			var monIdSig = $(this).attr('data-sig');
			console.log("signalement : "+monIdSig);
			var monUrl = "{{ path('ignoreSignalementAdmin',{ 'idSig': 'monIdSig'}) }}";
			monUrl = monUrl.replace('monIdSig',monIdSig);
			console.log(monUrl);
			
			// traitement AJAX
			$.ajax({
				url : monUrl ,
				dataType: "json" 
				

				}).done(function(){
					// en cas de succès
					console.log("commentaire supprimé");
					// faire disparaitre la ligne
					trButton.hide();
				}
			).fail(function(err){
				// ('Echec ajax');
				console.log("échec ajax");			
			});
		});
		

		$(".supprimer-decrypt").click(function(){
			console.log("suppression demandée");
			var myButton = $(this);
			var trButton = myButton.parent().parent();
			var monId = $(this).attr('data-button');
			console.log("monId : "+monId);
			var monIdSig = $(this).attr('data-sig');
			console.log("signalement : "+monIdSig);
			var monUrl = "{{ path('delDecryptAdmin',{'id': 'monId','idSig': 'monIdSig'}) }}";
			monUrl = monUrl.replace('monId',monId);
			monUrl = monUrl.replace('monIdSig',monIdSig);
			console.log(monUrl);
			$.ajax({
				url : monUrl ,
				dataType: "json" 
				}).done(function(){
					// en cas de succès
					console.log("décryptage supprimé");
					// faire disparaitre la ligne
					trButton.hide();
				}
			).fail(function(err){
				 // Echec ajax
				console.log("échec ajax");			
			});
		});
	
		
	});
	