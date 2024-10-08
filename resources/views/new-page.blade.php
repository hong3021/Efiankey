<!DOCTYPE html>
<html>

<head>
	<title>three.js css3d - periodic table</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
	<link type="text/css" rel="stylesheet" href="main.css">
	<style>
		a {
			color: #8ff;
		}

		#menu {
			position: absolute;
			bottom: 20px;
			width: 100%;
			text-align: center;
		}

		.element {
			width: 240px;
			height: 320px;
			box-shadow: 0px 0px 12px rgba(0, 255, 255, 0.5);
			border: 1px solid rgba(127, 255, 255, 0.25);
			font-family: Helvetica, sans-serif;
			text-align: center;
			line-height: normal;
			cursor: default;
		}

		.element:hover {
			box-shadow: 0px 0px 12px rgba(0, 255, 255, 0.75);
			border: 1px solid rgba(127, 255, 255, 0.75);
		}

		.element .number {
			position: absolute;
			top: 5px;
			right: 20px;
			font-size: 12px;
			color: rgba(127, 255, 255, 0.75);
		}

		.element .symbol {
			position: absolute;
			top: 20px;
			left: 0px;
			right: 0px;
			font-size: 60px;
			font-weight: bold;
			color: rgba(255, 255, 255, 0.75);
			text-shadow: 0 0 10px rgba(0, 255, 255, 0.95);
		}

		.element .details {
			position: absolute;
			bottom: 15px;
			left: 0px;
			right: 0px;
			font-size: 12px;
			color: rgba(127, 255, 255, 0.75);
		}

		button {
			color: rgba(127, 255, 255, 0.75);
			background: transparent;
			outline: 1px solid rgba(127, 255, 255, 0.75);
			border: 0px;
			padding: 5px 10px;
			cursor: pointer;
		}

		button:hover {
			background-color: rgba(0, 255, 255, 0.5);
		}

		button:active {
			color: #000000;
			background-color: rgba(0, 255, 255, 0.75);
		}
	</style>
</head>

<body>
	
	<div id="info"><a href="https://threejs.org" target="_blank" rel="noopener">three.js</a> css3ds - periodic table.
	</div>
	<div id="container"></div>
	<div id="menu">
		<button id="table">TABLE</button>
		<button id="sphere">SPHERE</button>
		<button id="helix">HELIX</button>
		<button id="grid">GRID</button>
	</div>

	<script type="importmap">
		{
				"imports": {
					"three": "https://unpkg.com/three@v0.163.0/build/three.module.js",
					"three/addons/": "https://unpkg.com/three@v0.163.0/examples/jsm/"
				}
			}
		</script>

	<script type="module">
			import * as THREE from 'three';
			import TWEEN from 'three/addons/libs/tween.module.js';
			import { TrackballControls } from 'three/addons/controls/TrackballControls.js';
			import { CSS3DRenderer, CSS3DObject } from 'three/addons/renderers/CSS3DRenderer.js';

			
			

		
			let camera, scene, renderer;
			let controls;
			//get data from google sheet
			const objects = [];
			const targets = { table: [], sphere: [], helix: [], grid: [] };
			const apiKey = 'AIzaSyAFZtI6bEjjrTuycdd_c_xrjkqP6VV8n6k'
					const spreadsheetId = '1LRe0EWszFx2ZacD_B9h8ShHhKwOj8MkVqayAv_VNLTA';
					const range = 'Data Template!A2:F201'
					const url = `https://sheets.googleapis.com/v4/spreadsheets/${spreadsheetId}/values/${range}?key=${apiKey}`;

					let tablesData = [];
					
					fetch(url)
					.then(response => response.json())
					.then(data => {
						tablesData = data.values
						if (data.length < 0) {
							console.log('No data found.');
						}else{
							init(tablesData);
							animate();
						}
					})
					.catch(error => console.error('Error fetching data:', error));
			// init();
			
			
			function init(tablesData) {
					
					camera = new THREE.PerspectiveCamera( 40, window.innerWidth / window.innerHeight, 1, 10000 );
					camera.position.z = 3000;

					scene = new THREE.Scene();

					// table					
					for ( let i = 0; i < tablesData.length; i++ ) {
						let tableData = tablesData[i];
						
						const element = document.createElement( 'div' );
						element.className = 'element';
						// if Red <$100K, Orange >$100K & Green >$200K
						let networth = Number( tableData[ 5 ].replace(/[^0-9.-]+/g, ""));
						
						if (networth > 200000 ){
							element.style.backgroundColor = 'rgba(58, 159, 72,' + ( Math.random() * 0.5 + 0.25 ) + ')';
						}else if (networth > 100000){
							element.style.backgroundColor = 'rgba(253, 202, 56,' + ( Math.random() * 0.5 + 0.25 ) + ')';
						}else{
							element.style.backgroundColor = 'rgba(239, 48, 34,' + ( Math.random() * 0.5 + 0.25 ) + ')';
						}
						 
						
							
						//nation
						const number = document.createElement( 'div' );
						number.className = 'number';
						number.textContent = tableData[3];
						element.appendChild( number );

						//image
						const symbol = document.createElement( 'div' );
						symbol.className = 'symbol';
						symbol.innerHTML = `<img src="${tableData[1]}" style="width: 100%; height: 100%;">`; // Use innerHTML to set the image HTML
						element.appendChild( symbol );

						//name , age, networth
						const details = document.createElement( 'div' );
						details.className = 'details';
						details.innerHTML = tableData[0] + tableData[2] + '<br>' + tableData[ 5 ];
						element.appendChild( details );

						const objectCSS = new CSS3DObject( element );
						objectCSS.position.x = Math.random() * 4000 - 2000;
						objectCSS.position.y = Math.random() * 4000 - 2000;
						objectCSS.position.z = Math.random() * 4000 - 2000;
						scene.add( objectCSS );

						objects.push( objectCSS );

						const object = new THREE.Object3D();
						object.position.x = ( ((i % 20)) * 340 ) - 1330;
						object.position.y = - ((Math.floor(i / 20)) * 360 ) + 990;
						targets.table.push( object );

					}

				// sphere
					
				const vector = new THREE.Vector3();

				for ( let i = 0, l = objects.length; i < l; i ++ ) {

					const phi = Math.acos( - 1 + ( 2 * i ) / l );
					const theta = Math.sqrt( l * Math.PI ) * phi;

					const object = new THREE.Object3D();

					object.position.setFromSphericalCoords( 1600, phi, theta );

					vector.copy( object.position ).multiplyScalar( 2 );

					object.lookAt( vector );

					targets.sphere.push( object );

				}

				// helix

				for ( let i = 0, l = objects.length; i < l; i ++ ) {

					const theta = i * 0.175 + Math.PI;
					const y = - ( i * 10 ) + 900;

					const object = new THREE.Object3D();

					object.position.setFromCylindricalCoords( 2000, theta, y );

					vector.x = object.position.x * 2;
					vector.y = object.position.y;
					vector.z = object.position.z * 2;

					object.lookAt( vector );

					targets.helix.push( object );

					const theta2 = i * 0.175 + Math.PI; // same theta calculation
					const y2 = - (i * 10) - 900; // same y calculation

					const object2 = new THREE.Object3D();
					object2.position.setFromCylindricalCoords(2000, theta2, y2); // Offset by changing radius

					vector.x = object2.position.x * 2;
					vector.y = object2.position.y ;
					vector.z = object2.position.z * 2;

					object2.lookAt(vector);

					targets.helix.push(object2);
					
				}

				// grid

				for ( let i = 0; i < objects.length; i ++ ) {

					const object = new THREE.Object3D();

					object.position.x = ( ( i % 4 ) * 400 ) - 800;
					object.position.y = ( - ( Math.floor( i / 5 ) % 5 ) * 400 ) + 800;
					object.position.z = ( Math.floor( i / 25 ) ) * 1000 - 2000;

					targets.grid.push( object );

				}

				//

				renderer = new CSS3DRenderer();
				renderer.setSize( window.innerWidth, window.innerHeight );
				document.getElementById( 'container' ).appendChild( renderer.domElement );

				//

				controls = new TrackballControls( camera, renderer.domElement );
				controls.minDistance = 500;
				controls.maxDistance = 6000;
				controls.addEventListener( 'change', render );

				const buttonTable = document.getElementById( 'table' );
				buttonTable.addEventListener( 'click', function () {

					transform( targets.table, 2000 );

				} );

				const buttonSphere = document.getElementById( 'sphere' );
				buttonSphere.addEventListener( 'click', function () {

					transform( targets.sphere, 2000 );

				} );

				const buttonHelix = document.getElementById( 'helix' );
				buttonHelix.addEventListener( 'click', function () {

					transform( targets.helix, 2000 );

				} );

				const buttonGrid = document.getElementById( 'grid' );
				buttonGrid.addEventListener( 'click', function () {

					transform( targets.grid, 2000 );

				} );

				transform( targets.table, 2000 );

				//

				window.addEventListener( 'resize', onWindowResize );

			}

			function transform( targets, duration ) {

				TWEEN.removeAll();

				for ( let i = 0; i < objects.length; i ++ ) {

					const object = objects[ i ];
					const target = targets[ i ];

					new TWEEN.Tween( object.position )
						.to( { x: target.position.x, y: target.position.y, z: target.position.z }, Math.random() * duration + duration )
						.easing( TWEEN.Easing.Exponential.InOut )
						.start();

					new TWEEN.Tween( object.rotation )
						.to( { x: target.rotation.x, y: target.rotation.y, z: target.rotation.z }, Math.random() * duration + duration )
						.easing( TWEEN.Easing.Exponential.InOut )
						.start();

				}

				new TWEEN.Tween( this )
					.to( {}, duration * 2 )
					.onUpdate( render )
					.start();

			}

			function onWindowResize() {

				camera.aspect = window.innerWidth / window.innerHeight;
				camera.updateProjectionMatrix();

				renderer.setSize( window.innerWidth, window.innerHeight );

				render();

			}

			function animate() {

				requestAnimationFrame( animate );

				TWEEN.update();

				controls.update();

			}

			function render() {

				renderer.render( scene, camera );

			}

	</script>
</body>

</html>