<?php
    defined('BASEPATH') OR exit("ooops, we are sorry. It's not you, it's us! Please use the back navigation button to go back.");

    ////////////////////////////////////////////////////////////////////////////////////////
    // LOAD ASSETS
    ////////////////////////////////////////////////////////////////////////////////////////
    $this->load->helper( 'url' );
    $images = base_url() . "";
    $assets = base_url() . "assets/";
    $cssbase = base_url() . "assets/css/";
    $jsbase = base_url() . "assets/js/";

    $base = base_url() . index_page();
    ////////////////////////////////////////////////////////////////////////////////////////

?>

	<!-- Le javascript
	================================================== -->

	<!-- Placed at the end of the document so the pages load faster -->

	<script type="text/javascript">
    let cursorWidth = parseInt(<?php echo $general_settings[0]->cursor_size; ?>);
     function zoomin() {
  var myImg = document.getElementById("img_solution");
  var currWidth = myImg.clientWidth;
  var clientHeight = myImg.clientHeight;
  if (currWidth == 2500 && clientHeight==1500 ) return false;
  else {
    myImg.style.width = (currWidth + 100) + "px";
    myImg.style.height = (clientHeight + 100) + "px";
  }
}

function zoomout() {
  var myImg = document.getElementById("img_solution");
  var currWidth = myImg.clientWidth;
  var clientHeight = myImg.clientHeight;
  if (currWidth == 100) return false;
  else {
    myImg.style.width = (currWidth - 100) + "px";
    myImg.style.height = (clientHeight - 100) + "px";
  }
}
function zoomin1() {
  var myImg = document.getElementById("img_challenge");
  var currWidth = myImg.clientWidth;
  var clientHeight = myImg.clientHeight;
  if (currWidth == 2500 && clientHeight==1500 ) return false;
  else {
    myImg.style.width = (currWidth + 100) + "px";
    myImg.style.height = (clientHeight + 100) + "px";
  }
}

function zoomout1() {
  var myImg = document.getElementById("img_challenge");
  var currWidth = myImg.clientWidth;
  var clientHeight = myImg.clientHeight;
  if (currWidth == 100) return false;
  else {
    myImg.style.width = (currWidth - 100) + "px";
    myImg.style.height = (clientHeight - 100) + "px";
  }
}
//function for browse image chalange

        function BrowsechalangeImage(){
            // alert("tum");
          
            var fd = new FormData();
            var files = $("#img_browse_challenge")[0].files[0];
            fd.append("img_browse_challenge",files);

            // AJAX request
            $.ajax({
              url: 'choosePhoto?image_id=<?php echo $unique_image_id; ?>&name=challenge&inputname=img_browse_challenge',
              type: 'post',
              data: fd,
              contentType: false,
              processData: false,
              success: function(response){
                //console.log(response);
                if(response != 0){
                    document.getElementById('challenge_img_name').value=response;

                    d = new Date();
                    $('#img_challenge').attr("src", "<?php echo $assets; ?>game_images/gallery/"+response+"?"+d.getTime());

                    console.log("success");
                }else{
                    alert('file not uploaded');
                }
              }
            });
        };  



   function upload(){

            var fd = new FormData();
            console.log(fd);
            var files = $('#file')[0].files[0];
            fd.append('file',files);

            // AJAX request
            $.ajax({
              url: 'choosePhoto?image_id=<?php echo $unique_image_id; ?>&name=solution&inputname=file',
              type: 'post',
              data: fd,
              contentType: false,
              processData: false,
              success: function(response){
                //console.log(response);
                if(response != 0){
                    document.getElementById('solution_img_name').value=response;

                    d = new Date();
                    $('#img_solution').attr("src", "<?php echo $assets; ?>game_images/gallery/"+response+"?"+d.getTime());

                    console.log("success");
                }else{
                    alert('file not uploaded');
                }
              }
            });
          };






var loadFile = function(event) {
  // alert(URL.createObjectURL(event.target.files[0]));
(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
'use strict';

var SpotTheBall = require('./spot-the-ball');

new SpotTheBall(document.getElementById('spot-the-ball-demo'), {
  size: {x: 700, y: 515, ball: cursorWidth},
  challengeImage: URL.createObjectURL(event.target.files[0]),
  solutionImage: URL.createObjectURL(event.target.files[0]),
  heatMap: [{"x":668,"y":458,"weight":0.6},{"x":607,"y":471,"weight":0.44},{"x":551,"y":450,"weight":0.59},{"x":566,"y":472,"weight":0.32},{"x":619,"y":453,"weight":0.67},{"x":640,"y":457,"weight":0.32},{"x":636,"y":434,"weight":0.28},{"x":603,"y":415,"weight":0.3},{"x":605,"y":397,"weight":0.4},{"x":649,"y":393,"weight":0.8},{"x":638,"y":411,"weight":0.26},{"x":688,"y":408,"weight":0.27},{"x":714,"y":407,"weight":0.41},{"x":716,"y":453,"weight":0.72},{"x":713,"y":475,"weight":0.96},{"x":698,"y":476,"weight":0.55},{"x":659,"y":480,"weight":0.67},{"x":594,"y":481,"weight":0.83},{"x":538,"y":477,"weight":0.37},{"x":499,"y":454,"weight":0.82},{"x":485,"y":471,"weight":0.59},{"x":482,"y":449,"weight":0.97},{"x":459,"y":480,"weight":0.22},{"x":459,"y":466,"weight":0.31},{"x":444,"y":435,"weight":0.24},{"x":423,"y":469,"weight":0.4},{"x":404,"y":450,"weight":0.61},{"x":383,"y":480,"weight":0.97},{"x":343,"y":480,"weight":0.92},{"x":348,"y":423,"weight":0.98},{"x":351,"y":425,"weight":0.66},{"x":382,"y":425,"weight":0.42},{"x":485,"y":417,"weight":0.96},{"x":517,"y":417,"weight":0.98},{"x":562,"y":366,"weight":0.49},{"x":567,"y":405,"weight":0.7},{"x":552,"y":347,"weight":0.63},{"x":610,"y":349,"weight":0.51},{"x":560,"y":335,"weight":0.57},{"x":557,"y":370,"weight":0.33}]
});
},{"./spot-the-ball":2}],2:[function(require,module,exports){
/*!
 * spot-the-ball.js v1.0.1
 * http://tomyouds.github.io/spot-the-ball.js
 *
 * Copyright (c) 2014 Tom Youds
 * Licensed under the MIT license
 */

(function (root, factory) {
  if (typeof define === 'function' && define.amd) {
    // AMD. Register as an anonymous module.
    define([], function () {
      return (root.returnExportsGlobal = factory());
    });
  } else if (typeof exports === 'object') {
    // Node. Does not work with strict CommonJS, but
    // only CommonJS-like enviroments that support module.exports,
    // like Node.
    module.exports = factory();
  } else {
    root['SpotTheBall'] = factory();
  }
}(this, function () {

  var GUESS_COLORS = [
    'skyblue',
    'yellow',
    'orange'
  ];

  var SVG = function(el) {
    var elem = new SVG.Element('svg', el);
    el.appendChild(elem.node);
    return elem;
  };

  var supportsSVG = function() {
    return !!document.createElementNS && !!document.createElementNS('http://www.w3.org/2000/svg', 'svg').createSVGRect;
  };

  var camelCase = function(s) {
    return s.toLowerCase().replace(/-(.)/g, function(m, g) {
      return g.toUpperCase();
    });
  };

  // var localStorageKey = function(id, prefix) {
  //   if (prefix == null) {
  //     prefix = 'spot-the-ball';
  //   }

  //   return prefix + '.' + id;
  // };

  var eventCoordinates = function(event) {
    x = event.clientX;
    y = event.clientY;
    if (webkit_mouse_bug44083 === 1 || (webkit_mouse_bug44083 === 0 && detectWebkitBug44083())) {
      x = event.pageX;
      y = event.pageY;
    }
// console.log(x,y)
    return {x: x, y: y};
  };

  // Safari bug getScreenCTM ignores scrolling
  // https://bugs.webkit.org/show_bug.cgi?id=44083
  // https://github.com/mbostock/d3/issues/1903
  // https://github.com/mbostock/d3/blob/d6598447cc972385fc34ca10f542fc53ad174183/src/event/mouse.js
  var webkit_mouse_bug44083 = /WebKit/.test(navigator.userAgent) ? 0 : -1;

  var detectWebkitBug44083 = function() {
    if (window.scrollX || window.scrollY) {
      var svg = SVG(document.body).style({
        position: 'absolute',
        top: 0,
        left: 0,
        margin: 0,
        padding: 0,
        border: 'none'
      });

      var ctm = svg.node.getScreenCTM();
      document.body.removeChild(svg.node);
      webkit_mouse_bug44083 = !(ctm.f || ctm.e) ? 1 : -1;
      return webkit_mouse_bug44083;
    }

    webkit_mouse_bug44083 = 0;
    return webkit_mouse_bug44083;
  };
  // SVG helper functions based on svg.js API
  SVG.Element = function(name, parent, nonSvg) {
    if (nonSvg) {
      this.node = document.createElement(name);
    }
    else {
      this.node = document.createElementNS('http://www.w3.org/2000/svg', name);
    }
    this.parent = parent;
  };

  SVG.Element.prototype.attr = function(attributes, value) {
    if (typeof attributes === 'object') {
      for (var v in attributes) {
        this.attr(v, attributes[v]);
      }
    }
    else {
      this.node.setAttribute(attributes, value.toString());
    }

    return this;
  };

  SVG.Element.prototype.style = function(attributes, value) {
    applyCSS(this.node, attributes, value);

    return this;
  };

  var applyCSS = function(node, attributes, value) {
    if (typeof attributes === 'object') {
      for (var v in attributes) {
        applyCSS(node, v, attributes[v]);
      }
    }
    else {
      node.style[camelCase(attributes)] = value;
    }
  };

  SVG.Element.prototype.image = function(src) {
    var elem = new SVG.Element('img', this, true);
    elem.attr({src: src, width: '100%'});
    elem.style({position: 'absolute', top: 0, left: 0});
    this.node.parentNode.appendChild(elem.node);
    return elem;
  };

  SVG.Element.prototype.circle = function(size) {
    var elem = new SVG.Element('circle');
    // console.log(size);
    var radius = size/2;
    elem.attr({r: radius});
    this.node.appendChild(elem.node);
    return elem;
  };

  SVG.Element.prototype.rect = function(w, h) {
    var elem = new SVG.Element('rect');
    elem.attr({width: w, height: h});
    this.node.appendChild(elem.node);
    return elem;
  };

  SVG.Element.prototype.text = function(content) {
    var elem = new SVG.Element('text');
    var tspan = new SVG.Element('tspan');
    tspan.node.appendChild(document.createTextNode(content));
    elem.node.appendChild(tspan.node);
    this.node.appendChild(elem.node);
    return elem;
  };

  SVG.Element.prototype.group = function() {
    var elem = new SVG.Element('g');
    this.node.appendChild(elem.node);
    return elem;
  };

  SVG.Element.prototype.hide = function() {
    return this.style('opacity', '0');
  };

  SVG.Element.prototype.show = function() {
    return this.style('opacity', '1');
  };

  SVG.Element.prototype.on = function(event, func) {
    this.node.addEventListener(event, func);
  };

  SVG.Element.prototype.move = function(x, y) {
    this.attr({cx: x, cy: y});
  };
  function SpotTheBall(element, options) {
    if (supportsSVG()) {
      this.element = element;
      this.options = options || {};

      // Scale font-size based on viewBox width
      this.fontSize = 0.021333333*options.size.x;

      // Block all actions after guess is made
      this.complete = false;

      applyCSS(this.element, {
        'padding-top': (this.options.size.y/this.options.size.x)*100 + '%',
        width: '100%',
        display: 'block',
        height: 'auto',
        position: 'relative'
      });

      this.preloadImages(function() {
        // Create SVG elements
        this.createElements();

        // Add heatmap
        this.addHeatMap();

        if (this.options.id && localStorage.getItem(localStorageKey(this.options.id))) {
          var savedGuess = JSON.parse(localStorage.getItem(localStorageKey(this.options.id)));
          // console.log(savedGuess);
          this.focus();
          this.makeGuess(savedGuess.guess.x, savedGuess.guess.y, true);
        }

        // Display bootstrapped guesses
        this.guesses = [];

        if (this.options.guesses) {
          this.options.guesses.forEach(function(guess, i) {
            this.displayGuess(guess.x, guess.y, GUESS_COLORS[i%GUESS_COLORS.length], false);
          }, this);
        }

        this.element.className = (this.element.className + ' ' + (this.complete ? 'complete' : 'incomplete')).trim();

        // Listen for events
        this.eventListeners();
      }.bind(this));
    }
    else {
      element.innerHTML = 'You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to play.';
    }
  }

  SpotTheBall.prototype = {
    createElements: function() {
      // Clear root element
      this.element.textContent = '';

      this.container = SVG(this.element).attr({
        viewBox: '0 0 ' + this.options.size.x + ' ' + this.options.size.y
      });

      this.container.style({
        width: '100%',
        height: '100%',
        position: 'absolute',
        top: 0,
        left: 0,
        overflow: 'hidden',
        // cursor: 'pointer'
      });


      this.challengeImage = this.container.image(this.options.challengeImage, this.options.size.x, this.options.size.y).attr('class', 'challenge');
      this.solutionImage = this.container.image(this.options.solutionImage, this.options.size.x, this.options.size.y).attr('class', 'solution').hide();

      // Fix for moving images on opacity change
      // [this.challengeImage, this.solutionImage].forEach(function(img) {
      //   img.style({
      //     '-webkit-backface-visibility': 'hidden',
      //     'backface-visibility': 'hidden',
      //     '-webkit-transform': 'rotate(0)',
      //     'transform': 'rotate(0)'
      //   });
      // });

      this.element.appendChild(this.challengeImage.node);
      // this.element.appendChild(this.solutionImage.node);

      this.element.appendChild(this.container.node);

      // this.heatMap = this.container.group().attr('class', 'heat-map').style({opacity: 0});

      this.cursor = this.container.circle(this.options.size.ball-8).attr({
        'class': 'cursor',
        fill: 'none',
        'stroke-width': '8',
        stroke: 'purple',
        opacity: 0.75,
        cx: this.options.size.x/2,
        cy: this.options.size.y/2
      }).hide();

      this.overlay = this.container.group().attr('class', 'overlay');
      this.overlay.rect(this.options.size.x, this.options.size.y).attr({fill: '#000', opacity: 0.5});

      var label;

      // if(('ontouchstart' in window) || (window.DocumentTouch && document instanceof DocumentTouch)) {
      //   label = 'Touch where you think the ball is';
      // }
      // else {
      //   label = 'Click where you think the ball is';
      // }


      // this.addLabel({x: this.options.size.x/2, y: this.options.size.y/2, 'text-anchor': 'middle', 'alignment-baseline': 'middle'}, label, this.overlay);
    },

    preloadImages: function(next) {
      // Preload images
      var preloadChallenge = document.createElement('img');
      var preloadSolution = document.createElement('img');
      var loaded = 0;

      var preloaded = function() {
        loaded++;
        if (loaded >= 2) {
          next();
        }
      };

      preloadChallenge.onload = preloaded;
      preloadSolution.onload = preloaded;

      preloadChallenge.src = this.options.challengeImage;
      preloadSolution.src = this.options.solutionImage;
    },


    eventListeners: function() {
      this.container.on('mousemove', (function(event) {
        if (this.complete) return;

        this.focus();

        var point = this.scalePoint(eventCoordinates(event));
// console.log(point);
        this.cursor.move(point.x, point.y);
      }).bind(this));

      this.container.on('mouseleave', this.blur.bind(this));
      // this.container.on('mouseenter', this.focus.bind(this));

      // this.container.on('touchstart', (function(event) {
      //   if (this.complete) return;
      //   window.clearTimeout(this.resetTimer);
      //   this.removeConfirmBox();
      //   this.focus();

      //   var point = this.scalePoint(eventCoordinates(event.touches[0]));
      //   // console.log(point);
      //   this.cursor.move(point.x, point.y);

      //   event.preventDefault();
      // }).bind(this));

      // this.container.on('touchmove', (function(event) {
      //   if (this.complete) return;

      //   var point = this.scalePoint(eventCoordinates(event.touches[0]));
      //   this.cursor.move(point.x, point.y);

      //   event.preventDefault();
      // }).bind(this));

      this.container.on('touchend', (function(event) {
        if (this.complete) return;

        var point = this.scalePoint(eventCoordinates(event.changedTouches[0]));
        this.cursor.move(point.x, point.y);

        // Moved out of view
        // if (point.x < 0 || point.y < 0 || point.x > this.options.size.x || point.y > this.options.size.y) {
        //   return this.blur();
        // }

        // Add a confirm label for touch
        // if (point.x < this.options.size.x/2) {
        //   // Right
        //   pos = {x: point.x+(this.options.size.ball/2)+20, y: point.y, 'text-anchor': 'start'};
        // }
        // else {
        //   // Left
        //   pos = {x: point.x-(this.options.size.ball/2)-20, y: point.y, 'text-anchor': 'end'};
        // }

        // this.removeConfirmBox();

        this.confirmBox = this.container.group();

        this.addLabel('Tap here to confirm guess', this.confirmBox);

        // Bind all touch events for confirm box
        // this.confirmBox.on('touchstart', function(event) {
        //   event.stopPropagation();
        //   event.preventDefault();
        // });

        // this.confirmBox.on('touchmove', function(event) {
        //   event.stopPropagation();
        //   event.preventDefault();
        // });

        // this.confirmBox.on('touchend', (function(event) {
        //   this.makeGuess(point.x, point.y);
        //   this.container.node.removeChild(this.confirmBox.node);
        //   this.confirmBox = null;
        // }).bind(this));


        // Reset if guess not confirmed after 10s
        // this.resetTimer = window.setTimeout((function() {
        //   this.removeConfirmBox();
        //   this.blur();
        // }).bind(this), 10000);

        event.preventDefault();
      }).bind(this));


      this.container.on('click', (function(event) {
        if (this.complete) return;
        this.focus();

        point = this.scalePoint(eventCoordinates(event));

        this.makeGuess(point.x, point.y);
      }).bind(this));


      
    },

    // removeConfirmBox: function() {
    //   if (this.confirmBox) {
    //     this.container.node.removeChild(this.confirmBox.node);
    //     this.confirmBox = null;
    //   }
    // },

    scalePoint: function(point) {
      var svgPoint = this.container.node.createSVGPoint();
      svgPoint.x = point.x;
      svgPoint.y = point.y;

      svgPoint = svgPoint.matrixTransform(this.container.node.getScreenCTM().inverse());

      return {x: svgPoint.x, y: svgPoint.y};
    },

    focus: function() {
      if (this.complete) return;
      this.overlay.hide();
      this.cursor.show();
    },

    blur: function() {
      if (this.complete) return;
      this.overlay.show();
      this.cursor.hide();
    },

    // heatSpot: function(spot) {
    //   this.heatMap.circle(this.options.size.ball).attr({cx: spot.x, cy: spot.y, fill: 'white', opacity: Math.min((spot.weight*2 || 1), 1)});
    // },

    addHeatMap: function() {
      if (this.options.heatMap && this.options.heatMap.length) {
        // this.options.heatMap.forEach(this.heatSpot, this);
      }
    },

    // calculateDistance: function(x, y) {
    //   return Math.round(Math.sqrt(Math.pow(this.options.solution.x-x, 2)+Math.pow(this.options.solution.y-y, 2)));
    // },

    makeGuess: function(x, y, previous) {
      if (this.complete) return;
      $('#x_axis').val(x);
      $('#y_axis').val(y);
      var guess = {x: x, y: y};
      

      // Check accuracy
      // // var distance = this.calculateDistance(x, y);
      // console.log(distance);
      // var correct = distance < this.options.size.ball;

      // Show solution
      // this.solutionImage.show();

      // this.container.style({
      //   cursor: 'default'
      // });

      this.complete = true;

      // this.heatMap.style({opacity: 0.75});

      // if (this.guesses && this.guesses.length) {
      //   this.guesses.forEach(function(guess) {
      //     guess.style({opacity: 1});
      //   });
      // }

      // Display actual guess
      // this.displayGuess(guess.x, guess.y, correct ? 'limegreen' : 'red', true);

      // if (previous) {
      //   this.container.attr('class', 'complete');
      //   return;
      // }

      // Store guess in localStorage
      // if (this.options.id) {
      //   localStorage.setItem(localStorageKey(this.options.id), JSON.stringify({guess: guess, distance: distance}));
      // }

      if (this.options.onGuess) this.options.onGuess.call(this, guess, distance);
    },

    // displayGuess: function(x, y, color, cursor) {
    //   if (cursor) {
    //     this.cursor.attr({
    //       'class': 'guess',
    //       cx: x,
    //       cy: y
    //     }).style('stroke', color);
    //   }
    //   else {
    //     this.guesses.push(this.container.circle(this.options.size.ball-8).attr({
    //       'class': 'guess',
    //       fill: 'none',
    //       'stroke-width': '8',
    //       stroke: color,
    //       opacity: 0.75,
    //       cx: x,
    //       cy: y
    //     }).hide());
    //   }
    // },

    addLabel: function(pos, text, container) {
      if (!container) {
        container = this.container;
      }

      var labelText  = container.text(text).attr({'font-size': this.fontSize, fill: '#FFF', 'dominant-baseline': 'central'}).attr(pos);

      var labelBox = labelText.node.getBBox();

      container.rect(labelBox.width+28, labelBox.height+20).attr({
        fill: 'black',
        opacity: 0.75,
        x: labelBox.x-14,
        y: labelBox.y-10,
        rx: 5,
        ry: 5
      });

      container.node.appendChild(labelText.node);
    }
  };

  return SpotTheBall;


}));

},{}]},{},[1]);
};
        

        
        // var imageLoader = document.getElementById('file');
        // imageLoader.addEventListener('change', handleImage, false);
        // var canvas = document.getElementById('imageCanvas');
        // var ctx = canvas.getContext('2d');

        // var cursor_x;
        // var cursor_y;

        // //Default cursor size
        // var cursor_size = 16;

        // var isSelected = false;

        // function handleImage(e){
        //     alert('hello');
        //     var reader = new FileReader();
        //     reader.onload = function(event){

        //         var img = new Image();
        //         img.onload = function(){
        //             // canvas.width = "713px";
        //             // canvas.height = "405px";
        //             ctx.drawImage(img,0,0,713,405);
        //         }
        //         img.src = event.target.result;
        //     }
        //     reader.readAsDataURL(e.target.files[0]);     
        // }

      // Click on mouse function
        // function getCursorPosition(canvas, event) {
        //     const rect = canvas.getBoundingClientRect();
        //     const x = event.clientX - rect.left;
        //     const y = event.clientY - rect.top;

        //     // Draw Circle on Click
        //     var ctx = canvas.getContext("2d");

        //     //Get cursor size
        //     cursor_size = $('#cursor_size').val();

        //     if(isSelected){
        //         //Clear previous arc
        //         ctx.strokeStyle = "rgba(255, 255, 255, 0.7)";
        //         ctx.lineWidth   = cursor_size;
        //         ctx.beginPath();
        //         ctx.arc(cursor_x,cursor_y,cursor_size,0,2*Math.PI);
        //         ctx.fillStyle = "rgba(255, 255, 255, 0.7)";
        //         ctx.fill();
        //         ctx.stroke();
        //     }

        //     cursor_x = x;
        //     cursor_y = y;

        //     isSelected = true;

            
        //     ctx.strokeStyle = "red";
        //     ctx.lineWidth   = cursor_size;
        //     ctx.beginPath();
        //     ctx.arc(x,y,cursor_size,0,2*Math.PI);
        //     // ctx.fillStyle = "red";
        //     // ctx.fill();
        //     ctx.stroke();

        //     //document.getElementById('x_axis').value=x;
        //     //document.getElementById('y_axis').value=y;
        //     $('#x_axis').val(cursor_x);
        //     $('#y_axis').val(cursor_y);
            
        //      console.log("x: " + x + " y: " + y);
        // }

        // canvas.addEventListener('mousedown', function(e) {
        //     getCursorPosition(canvas, e);
        // })
// testing


//end testing
          // Upload Photo With Ajax
          

          

          //Cancel adding image
          $("#btnCancelGalleryAdd").click(function(){
            //Get challenge_img_url
            var challenge_img_url= $('#challenge_img_name').val();
            //Get solution_img_url
            var solution_img_url= $('#solution_img_name').val();
            $.ajax({
                url: "deleteuploadimagesoncancel?challenge_img_url="+challenge_img_url+"&solution_img_url="+solution_img_url, 
                success: function(result){
                    //Reload page in 10 seconds
                    setTimeout(location.reload.bind(location), 1000);
                }
            });
          });


        


        //on focus readonly for solution image
        $(document).on("focusin", "#solution_img_name", function() {
           $(this).prop('readonly', true);  
        });
        $(document).on("focusout", "#solution_img_name", function() {
           $(this).prop('readonly', false); 
        });
        //on focus readonly for challenge image
        $(document).on("focusin", "#challenge_img_name", function() {
           $(this).prop('readonly', true);  
        });
        $(document).on("focusout", "#challenge_img_name", function() {
           $(this).prop('readonly', false); 
        });

        //on focus readonly for x-axis image
        $(document).on("focusin", "#x_axis", function() {
           $(this).prop('readonly', true);  
        });
        $(document).on("focusout", "#x_axis", function() {
           $(this).prop('readonly', false); 
        });
        //on focus readonly for y-axis image
        $(document).on("focusin", "#y_axis", function() {
           $(this).prop('readonly', true);  
        });
        $(document).on("focusout", "#y_axis", function() {
           $(this).prop('readonly', false); 
        });



    // function zoomin() {
    //     var myImg = document.getElementById("map");
    //     var currWidth = myImg.clientWidth;
    //     if (currWidth == 2500) return false;
    //     else {
    //         myImg.style.width = (currWidth + 100) + "px";
    //     }
    // }

    // function zoomout() {
    //     var myImg = document.getElementById("map");
    //     var currWidth = myImg.clientWidth;
    //     if (currWidth == 100) return false;
    //     else {
    //         myImg.style.width = (currWidth - 100) + "px";
    //     }
    // }

    // function zoomin_two() {
    //     var myImg = document.getElementById("map_two");
    //     var currWidth = myImg.clientWidth;
    //     if (currWidth == 2500) return false;
    //     else {
    //         myImg.style.width = (currWidth + 100) + "px";
    //     }
    // }

    // function zoomout_two() {
    //     var myImg = document.getElementById("map_two");
    //     var currWidth = myImg.clientWidth;
    //     if (currWidth == 100) return false;
    //     else {
    //         myImg.style.width = (currWidth - 100) + "px";
    //     }
    // }
                          
    </script>