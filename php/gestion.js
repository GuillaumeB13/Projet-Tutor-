function Shape(state, x, y, w, h, id, nom, fill, stroke) {
  "use strict";
  // This is a very simple and unsafe constructor. All we're doing is checking if the values exist.
  // "x || 0" just means "if there is a value for x, use that. Otherwise use 0."
  // But we aren't checking anything else! We could put "Lalala" for the value of x 
  this.state = state;
  this.x = x || 0;
  this.y = y || 0;
  this.w = w || 1;
  this.h = h || 1;
  this.id = id || 0;
  this.typeChamp = "texte";
  this.nomChamp = nom || "";
  this.fill = fill || 'rgba(255,0,0,0.3)';
  this.stroke = stroke || 'rgb(250,0,0)';
}
lastSelected = null;
originalCanvas = null;
// Draws this shape to a given context
Shape.prototype.draw = function(ctx, optionalColor) {
  "use strict";
  var i, cur, half;
  ctx.fillStyle = this.fill || 'rgba(255,0,0,0.3)';
  ctx.fillRect(this.x, this.y, this.w, this.h);
  ctx.lineWidth = 2;
  ctx.strokeStyle = this.stroke || 'rgb(250,0,0)';
  ctx.strokeRect(this.x, this.y, this.w, this.h);
  ctx.fillStyle = 'rgb(255,240,240)';
  ctx.font="16px Verdana";
  ctx.fillText(this.id,(this.x+this.w/2)-5,(this.y+this.h/2)+5);
  ctx.fillStyle = this.fill|| 'rgba(255,0,0,0.3)';
  if (this.state.selection === this) {
    ctx.strokeStyle = this.state.selectionColor;
    ctx.lineWidth = this.state.selectionWidth;
    ctx.strokeRect(this.x,this.y,this.w,this.h);
    
    // draw the boxes
    half = this.state.selectionBoxSize / 2;
    
    // 0  1  2
    // 3     4
    // 5  6  7
    
    // Haut gauche, milieu, droit
    this.state.selectionHandles[0].x = this.x-half;
    this.state.selectionHandles[0].y = this.y-half;
    
    this.state.selectionHandles[1].x = this.x+this.w/2-half;
    this.state.selectionHandles[1].y = this.y-half;
    
    this.state.selectionHandles[2].x = this.x+this.w-half;
    this.state.selectionHandles[2].y = this.y-half;
    
    //Milieu gauche
    this.state.selectionHandles[3].x = this.x-half;
    this.state.selectionHandles[3].y = this.y+this.h/2-half;
    
    //Milieu droit
    this.state.selectionHandles[4].x = this.x+this.w-half;
    this.state.selectionHandles[4].y = this.y+this.h/2-half;
    
    //Bas gauche, milieu, droit
    this.state.selectionHandles[6].x = this.x+this.w/2-half;
    this.state.selectionHandles[6].y = this.y+this.h-half;
    
    this.state.selectionHandles[5].x = this.x-half;
    this.state.selectionHandles[5].y = this.y+this.h-half;
    
    this.state.selectionHandles[7].x = this.x+this.w-half;
    this.state.selectionHandles[7].y = this.y+this.h-half;

    
    ctx.fillStyle = this.state.selectionBoxColor;
    for (i = 0; i < 8; i += 1) {
      cur = this.state.selectionHandles[i];
      ctx.fillRect(cur.x, cur.y, this.state.selectionBoxSize, this.state.selectionBoxSize);
    }
  }
};

// Determine if a point is inside the shape's bounds
Shape.prototype.contains = function(mx, my) {
  "use strict";
  // All we have to do is make sure the Mouse X,Y fall in the area between
  // the shape's X and (X + Height) and its Y and (Y + Height)
  return  (this.x <= mx) && (this.x + this.w >= mx) &&
          (this.y <= my) && (this.y + this.h >= my);
};

function CanvasState(canvas) {
  "use strict";
  // **** First some setup! ****
  
  this.canvas = canvas;
  this.width = canvas.width;
  this.height = canvas.height;
  this.ctx = canvas.getContext('2d');
  this.canvas.setAttribute("tabindex", 0);
  this.curID = 0; // Le nombre de formes ayant �t� cr��es, pour donner un id propre � chaque champ
  // This complicates things a little but but fixes mouse co-ordinate problems
  // when there's a border or padding. See getMouse for more detail
  var stylePaddingLeft, stylePaddingTop, styleBorderLeft, styleBorderTop,
      html, myState, i;
  if (document.defaultView && document.defaultView.getComputedStyle) {
    this.stylePaddingLeft = parseInt(document.defaultView.getComputedStyle(canvas, null).paddingLeft, 10)      || 0;
    this.stylePaddingTop  = parseInt(document.defaultView.getComputedStyle(canvas, null).paddingTop, 10)       || 0;
    this.styleBorderLeft  = parseInt(document.defaultView.getComputedStyle(canvas, null).borderLeftWidth, 10)  || 0;
    this.styleBorderTop   = parseInt(document.defaultView.getComputedStyle(canvas, null).borderTopWidth, 10)   || 0;
  }
  // Some pages have fixed-position bars (like the stumbleupon bar) at the top or left of the page
  // They will mess up mouse coordinates and this fixes that
  html = document.body.parentNode;
  this.htmlTop = html.offsetTop;
  this.htmlLeft = html.offsetLeft;

  // **** Keep track of state! ****
  
  this.valid = false; // when set to false, the canvas will redraw everything
  this.shapes = [];  // the collection of things to be drawn
  this.dragging = false; // Keep track of when we are dragging
  this.resizeDragging = false; // Keep track of resize
  this.expectResize = -1; // save the # of the selection handle 
  // the current selected object. In the future we could turn this into an array for multiple selection
  this.selection = null;
  this.dragoffx = 0; // See mousedown and mousemove events for explanation
  this.dragoffy = 0;
  
  // New, holds the 8 tiny boxes that will be our selection handles
  // the selection handles will be in this order:
  // 0  1  2
  // 3     4
  // 5  6  7
  this.selectionHandles = [];
  for (i = 0; i < 8; i += 1) {
    this.selectionHandles.push(new Shape(this));
  }
  
  // **** Then events! ****
  
  // This is an example of a closure!
  // Right here "this" means the CanvasState. But we are making events on the Canvas itself,
  // and when the events are fired on the canvas the variable "this" is going to mean the canvas!
  // Since we still want to use this particular CanvasState in the events we have to save a reference to it.
  // This is our reference!
  myState = this;
  this.backgroundimg = new Image();
  this.backgroundimg.src = "img/ci.png";
// Make sure the image is loaded first otherwise nothing will draw.
  /*background.onload = function(){
  myState.ctx.drawImage(background,0,0);   
  }*/
  //fixes a problem where double clicking causes text to get selected on the canvas
  canvas.addEventListener('selectstart', function(e) { e.preventDefault(); return false; }, false);
  // Up, down, and move are for dragging
  canvas.addEventListener('mousedown', function(e) {
    var mouse, mx, my, shapes, l, i, mySel;
    if (myState.expectResize !== -1) {
      myState.resizeDragging = true;
      return;
    }
    mouse = myState.getMouse(e);
    mx = mouse.x;
    my = mouse.y;
    shapes = myState.shapes;
    l = shapes.length;
    for (i = l-1; i >= 0; i -= 1) {
      if (shapes[i].contains(mx, my)) {
        mySel = shapes[i];
        // Keep track of where in the object we clicked
        // so we can move it smoothly (see mousemove)
        myState.dragoffx = mx - mySel.x;
        myState.dragoffy = my - mySel.y;
        myState.dragging = true;
        myState.selection = mySel;
    lastSelected = myState.selection;
    document.f.x.value = myState.selection.x;
    document.f.y.value = myState.selection.y;
    document.f.w.value = myState.selection.x+myState.selection.w;
    document.f.h.value = myState.selection.y+myState.selection.h;
    document.f.type.value = myState.selection.typeChamp;
    document.f.nom_champ.value = myState.selection.nomChamp;
    document.f.id.value = myState.selection.id;
        myState.valid = false;
        return;
      }
    }
    // havent returned means we have failed to select anything.
    // If there was an object selected, we deselect it
    if (myState.selection) {
      myState.selection = null;
      myState.valid = false; // Need to clear the old selection border
    }
  }, true);
  canvas.addEventListener('mousemove', function(e) {
    var mouse = myState.getMouse(e),
        mx = mouse.x,
        my = mouse.y,
        oldx, oldy, i, cur;
    if (myState.dragging){
      mouse = myState.getMouse(e);
      // We don't want to drag the object by its top-left corner, we want to drag it
      // from where we clicked. Thats why we saved the offset and use it here
      myState.selection.x = mouse.x - myState.dragoffx;
      myState.selection.y = mouse.y - myState.dragoffy;  
    document.f.x.value = myState.selection.x;
    document.f.y.value = myState.selection.y;
    document.f.w.value = myState.selection.x+myState.selection.w;
    document.f.h.value = myState.selection.y+myState.selection.h;
    
      myState.valid = false; // Something's dragging so we must redraw
    } else if (myState.resizeDragging) {
      // time ro resize!
      oldx = myState.selection.x;
      oldy = myState.selection.y;
      
      // 0  1  2
      // 3     4
      // 5  6  7
      switch (myState.expectResize) {
        case 0:
          myState.selection.x = mx;
          myState.selection.y = my;
          myState.selection.w += oldx - mx;
          myState.selection.h += oldy - my;
          break;
        case 1:
          myState.selection.y = my;
          myState.selection.h += oldy - my;
          break;
        case 2:
          myState.selection.y = my;
          myState.selection.w = mx - oldx;
          myState.selection.h += oldy - my;
          break;
        case 3:
          myState.selection.x = mx;
          myState.selection.w += oldx - mx;
          break;
        case 4:
          myState.selection.w = mx - oldx;
          break;
        case 5:
          myState.selection.x = mx;
          myState.selection.w += oldx - mx;
          myState.selection.h = my - oldy;
          break;
        case 6:
          myState.selection.h = my - oldy;
          break;
        case 7:
          myState.selection.w = mx - oldx;
          myState.selection.h = my - oldy;
          break;
      }
    document.f.x.value = myState.selection.x;
    document.f.y.value = myState.selection.y;
    document.f.w.value = myState.selection.x+myState.selection.w;
    document.f.h.value = myState.selection.y+myState.selection.h;
      myState.valid = false; // Something's dragging so we must redraw
    }
  
    // if there's a selection see if we grabbed one of the selection handles
    if (myState.selection !== null && !myState.resizeDragging) {
      for (i = 0; i < 8; i += 1) {
        // 0  1  2
        // 3     4
        // 5  6  7
        
        cur = myState.selectionHandles[i];
        
        // we dont need to use the ghost context because
        // selection handles will always be rectangles
        if (mx >= cur.x && mx <= cur.x + myState.selectionBoxSize &&
            my >= cur.y && my <= cur.y + myState.selectionBoxSize) {
          // we found one!
          myState.expectResize = i;
          myState.valid = false;
          
          switch (i) {
            case 0:
              this.style.cursor='nw-resize';
              break;
            case 1:
              this.style.cursor='n-resize';
              break;
            case 2:
              this.style.cursor='ne-resize';
              break;
            case 3:
              this.style.cursor='w-resize';
              break;
            case 4:
              this.style.cursor='e-resize';
              break;
            case 5:
              this.style.cursor='sw-resize';
              break;
            case 6:
              this.style.cursor='s-resize';
              break;
            case 7:
              this.style.cursor='se-resize';
              break;
          }
          return;
        }
        
      }
      // not over a selection box, return to normal
      myState.resizeDragging = false;
      myState.expectResize = -1;
      this.style.cursor = 'auto';
    }
  }, true);
  canvas.addEventListener('mouseup', function(e) {
    myState.dragging = false;
    myState.resizeDragging = false;
    myState.expectResize = -1;
    if (myState.selection !== null) {
      if (myState.selection.w < 0) {
          myState.selection.w = -myState.selection.w;
          myState.selection.x -= myState.selection.w;
      }
      if (myState.selection.h < 0) {
          myState.selection.h = -myState.selection.h;
          myState.selection.y -= myState.selection.h;
      }
    }
  }, true);
  canvas.addEventListener('onchange', function(e) {this.valid = false}, true);
  // double click for making new shapes
  canvas.addEventListener('dblclick', function(e) {
    var mouse = myState.getMouse(e);
    myState.addShape(new Shape(myState, mouse.x - 10, mouse.y - 10, 20, 20, myState.curID));
  myState.curID+=1;
  }, true);
  canvas.addEventListener('keydown', function(e) {
    if(myState.selection != null)
    if(e.keyCode == "46")
      for (var j = myState.shapes.length; j >= 0; j -= 1) {
        if (myState.shapes[j] == myState.selection){
          console.log(myState.shapes[j].x);
          myState.shapes.splice(j, 1);
          myState.selection = null;
          myState.valid = false;
        }
      }
  }, true);
  
  // **** Options! ****
  
  this.selectionColor = 'rgb(255,0,0)';
  this.selectionWidth = 2;  
  this.selectionBoxSize = 6;
  this.selectionBoxColor = 'rgb(200,0,0';
  this.interval = 30;
  setInterval(function() { myState.draw(); }, myState.interval);
  originalCanvas = this;
}

CanvasState.prototype.addShape = function(shape) {
  "use strict";
  this.shapes.push(shape);
  this.valid = false;
};

CanvasState.prototype.clear = function() {
  "use strict";
  this.ctx.clearRect(0, 0, this.width, this.height);
};
CanvasState.prototype.update = function(){
    
    lastSelected.x = parseInt(document.f.x.value) ;
    lastSelected.y = parseInt(document.f.y.value);
    lastSelected.w = parseInt(document.f.w.value-document.f.x.value);
    lastSelected.h = parseInt(document.f.h.value-document.f.y.value);
    lastSelected.typeChamp = document.f.type.value;
    lastSelected.nomChamp = document.f.nom_champ.value;
    lastSelected.id = document.f.id.value;
    originalCanvas.valid = false;
}
// While draw is called as often as the INTERVAL variable demands,
// It only ever does something if the canvas gets invalidated by our code
CanvasState.prototype.draw = function() {
  "use strict";
  var ctx, shapes, l, i, shape, mySel, background;
  // if our state is invalid, redraw and validate!
  if (!this.valid) {
    ctx = this.ctx;
    shapes = this.shapes;
  background = this.backgroundimg;
    this.clear();
  ctx.drawImage(background,0,0);  
    
    // ** Add stuff you want drawn in the background all the time here **
    
    // draw all shapes
    l = shapes.length;
    for (i = 0; i < l; i += 1) {
      shape = shapes[i];
      // We can skip the drawing of elements that have moved off the screen:
      if (shape.x <= this.width && shape.y <= this.height &&
          shape.x + shape.w >= 0 && shape.y + shape.h >= 0) {
        shapes[i].draw(ctx);
      }
    }
    
    // draw selection
    // right now this is just a stroke along the edge of the selected Shape
    if (this.selection !== null) {
      ctx.strokeStyle = this.selectionColor;
      ctx.lineWidth = this.selectionWidth;
      mySel = this.selection;
      ctx.strokeRect(mySel.x,mySel.y,mySel.w,mySel.h);
    }
    
    // ** Add stuff you want drawn on top all the time here **
    
    this.valid = true;
  }
};


// Creates an object with x and y defined, set to the mouse position relative to the state's canvas
// If you wanna be super-correct this can be tricky, we have to worry about padding and borders
CanvasState.prototype.getMouse = function(e) {
  "use strict";
  var element = this.canvas, offsetX = 0, offsetY = 0, mx, my;
  
  // Compute the total offset
  if (element.offsetParent !== undefined) {
    do {
      offsetX += element.offsetLeft;
      offsetY += element.offsetTop;
      element = element.offsetParent;
    } while (element);
  }

  // Add padding and border style widths to offset
  // Also add the <html> offsets in case there's a position:fixed bar
  offsetX += this.stylePaddingLeft + this.styleBorderLeft + this.htmlLeft;
  offsetY += this.stylePaddingTop + this.styleBorderTop + this.htmlTop;

  mx = e.pageX - offsetX;
  my = e.pageY - offsetY;
  
  // We return a simple javascript object (a hash) with x and y defined
  return {x: mx, y: my};
};

// If you dont want to use <body onLoad='init()'>
// You could uncomment this init() reference and place the script reference inside the body tag
//init();

function init() {
  //"use strict";
  s = new CanvasState(document.getElementById('canvas1'));
  // add a large green rectangle
//  s.addShape(new Shape(s, 260, 70, 60, 65));
  // add a green-blue rectangle
  //s.addShape(new Shape(s, 240, 120, 40, 40));  
  // add a smaller purple rectangle
  //s.addShape(new Shape(s, 5, 60, 25, 25));
}