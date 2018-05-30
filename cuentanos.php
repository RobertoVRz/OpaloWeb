<?php

require_once 'php/functions.php';
?>

<!DOCTYPE html>
<html lang="es">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ópalo Studio</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Pontano+Sans' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Playfair+Display' rel='stylesheet' type='text/css'>
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/stylish-portfolio.css" rel="stylesheet">
    <script type="text/javascript" src="js/paper-full.js"></script>

  </head>

  <body id="page-top" class="bg-light">
    <!-- Navigation -->
    <a class="menu-toggle rounded" href="#">
      <i class="fa fa-bars gradient" style="font-size:25px"></i>
    </a>
        <nav id="sidebar-wrapper">
      <ul class="sidebar-nav">
        <li class="sidebar-brand">
          <a class="js-scroll-trigger gradient" href="#page-top">Ópalo Studio</a>
        </li>
        <li class="sidebar-nav-item">
          <a class="js-scroll-trigger gradient" href="#about">¿Quiénes somos?</a>
        </li>
        <li class="sidebar-nav-item">
          <a class="js-scroll-trigger gradient" href="#services">¿Qué hacemos?</a>
        </li>
        <li class="sidebar-nav-item">
          <a class="js-scroll-trigger gradient" href="#contact">Cuéntanos de tu proyecto</a>
        </li>
      </ul>
    </nav>
    <!-- Header -->
    

    <div class="container-fixed h-100">
      <div class="text-center">
        <br>
        <h1>Iniciemos tu proyecto</h1><br>
        <p>Todo lo que nos cuentes...</p>
      </div>
      
      <div class="row h-75">
        <div class="col-10 mx-auto">
            <div class="row">
              <div class="col-md-6">
                Nombre
                <input type="text" class="form-control" id="name" placeholder="Escribe tu nombre">
              </div>
              <div class="col-md-6">
                Email
                <input type="text" class="form-control" id="email" placeholder="Escribe tu email">
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                Compañía
                <input type="text" class="form-control" id="company" placeholder="Escribe de tu compañía o empresa">
              </div>
            </div>
            <br>
            <div class="text-center">
              <a class="btn btn-custom btn-grad" id="text-faded">Siguiente</a>
            </div>
        </div>
      </div>


      
    </div>


    




    <!-- Map -->
    
      
    

    <!-- Footer 
    <footer class="footer text-center">
      
    </footer>-->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded js-scroll-trigger" href="#page-top">
      <i class="fa fa-angle-up gradient" style="font-size:25px"></i>
    </a>

    

  </body>

  <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="js/stylish-portfolio.min.js"></script>

    <script type="text/paperscript" canvas="canvas">
        // Code ported to Paper.js from http://the389.com/9/1/
        // with permission.

        var values = {
            friction: 0.8,
            timeStep: 0.01,
            amount: 15,
            mass: 2,
            count: 0
        };
        values.invMass = 1 / values.mass;

        var path, springs;
        var size = view.size * [1.2, 1];

        var Spring = function(a, b, strength, restLength) {
            this.a = a;
            this.b = b;
            this.restLength = restLength || 80;
            this.strength = strength ? strength : 0.55;
            this.mamb = values.invMass * values.invMass;
        };

        Spring.prototype.update = function() {
            var delta = this.b - this.a;
            var dist = delta.length;
            var normDistStrength = (dist - this.restLength) /
                    (dist * this.mamb) * this.strength;
            delta.y *= normDistStrength * values.invMass * 0.2;
            if (!this.a.fixed)
                this.a.y += delta.y;
            if (!this.b.fixed)
                this.b.y -= delta.y;
        };


        function createPath(strength) {
            var path = new Path({
                fillColor: '#AD1D72'
            });
            springs = [];
            for (var i = 0; i <= values.amount; i++) {
                var segment = path.add(new Point(i / values.amount, 0.5) * size);
                var point = segment.point;
                if (i == 0 || i == values.amount)
                    point.y += size.height;
                point.px = point.x;
                point.py = point.y;
                // The first two and last two points are fixed:
                point.fixed = i < 2 || i > values.amount - 2;
                if (i > 0) {
                    var spring = new Spring(segment.previous.point, point, strength);
                    springs.push(spring);
                }
            }
            path.position.x -= size.width / 4;
            return path;
        }

        function onResize() {
            if (path)
                path.remove();
            size = view.bounds.size * [2, 1];
            path = createPath(0.1);
        }

        function onMouseMove(event) {
            var location = path.getNearestLocation(event.point);
            var segment = location.segment;
            var point = segment.point;

            if (!point.fixed && location.distance < size.height / 4) {
                var y = event.point.y;
                point.y += (y - point.y) / 6;
                var previous = segment.previous && segment.previous.point;
                var next = segment.next && segment.next.point;
                if (previous && !previous.fixed)
                    previous.y += (y - previous.y) / 24;
                if (next && !next.fixed)
                    next.y += (y - next.y) / 24;
            }
        }

        function onFrame(event) {
            updateWave(path);
        }

        function updateWave(path) {
            var force = 1 - values.friction * values.timeStep * values.timeStep;
            for (var i = 0, l = path.segments.length; i < l; i++) {
                var point = path.segments[i].point;
                var dy = (point.y - point.py) * force;
                point.py = point.y;
                point.y = Math.max(point.y + dy, 0);
            }

            for (var j = 0, l = springs.length; j < l; j++) {
                springs[j].update();
            }
            path.smooth({ type: 'continuous' });
        }

        function onKeyDown(event) {
            if (event.key == 'space') {
                path.fullySelected = !path.fullySelected;
                path.fillColor = path.fullySelected ? null : 'black';
            }
        }
    </script>

    <script>
      var something = document.getElementById('head');
      var dimensions = something.getClientRects()[0];
      var pattern = document.getElementById('canvas');
      something.appendChild(pattern.canvas());
    </script>


</html>
