
$(function() {
  var canvas = document.getElementById('canvas');
  var ctx = canvas.getContext('2d');

  /* Enable Cross Origin Image Editing */
  var img = new Image();
  img.crossOrigin = '';
  img.src = 'identite.jpg';

  img.onload = function() {
    canvas.width = img.width;
    canvas.height = img.height;
    ctx.drawImage(img, 0, 0, img.width, img.height);
  }

$('input[type=range]').change(applyFilters);

function applyFilters() {
	var luminosite = parseInt($('#luminosite').val());
	var contraste = parseInt($('#contraste').val());

	Caman('#canvas', img, function() {
		this.revert(false);
		this.brightness(luminosite);
		this.contrast(contraste);
		this.render();
	});
}
});