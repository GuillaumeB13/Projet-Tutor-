
$(function() {
  var canvas = document.getElementById('canvas');
  var ctx = canvas.getContext('2d');

  var img = new Image();
  img.crossOrigin = '';
  img.src = 'identite.jpg';

  img.onload = function() {
    canvas.width = img.width;
    canvas.height = img.height;
    ctx.drawImage(img, 0, 0, img.width, img.height);
    initialize();
  }

function initialize() {
  Caman('#canvas', img, function() {
      this.rotate(1);
      this.rotate(-1);
      this.render();
      Caman('#canvas', img, function() {
        this.revert(false);
        this.render();
      });
  });
  
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

document.getElementById("valider").onclick = function ()
{
  Caman('#canvas', img, function() {
  this.render(function()
              {
                var image = this.toBase64();
                this.save();
              });
  });
}
document.getElementById("rotp").onclick = function ()
{
  Caman('#canvas', img, function() {
    this.revert(false);
    this.rotate(-1);
    this.render();
  });
  applyFilters();
}

document.getElementById("rotm").onclick = function ()
{
  Caman('#canvas', img, function() {
    this.revert(false);
    this.rotate(1);
    this.render();
  });
  applyFilters();
}

});