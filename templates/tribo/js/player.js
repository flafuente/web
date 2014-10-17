path = 'http://overonocc.cdn.customers.overon.es/tribotv/';

host = window.location.hostname;

rnd = parseInt(Math.random()*100000);
document.write('<script type="text/javascript" src="'+path+'js/overon_player.js?'+rnd+'"></script>');
document.write('<script type="text/javascript" src="'+path+'js/flash_detect.js?'+rnd+'"></script>');