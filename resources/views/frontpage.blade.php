<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        <script src="https://cdn.babylonjs.com/babylon.js"></script>
        <script src="https://cdn.babylonjs.com/loaders/babylonjs.loaders.min.js"></script>      
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  
        <script src="https://code.jquery.com/pep/0.4.3/pep.js"></script>     
        <script src="/js/CameraController.js"></script>     

    </head>

    <body id="body">
        <canvas id="canvas" crossorigin='anonymous' >

        </canvas>
 
        <script>                  
            $.ajaxSetup({cache:true});

            loadJSON(function(response) {            
                initParseContent( JSON.parse(response) );
            });

            var folderArea = "";    
            var descriptionText = "";   
            var cmsdata;        
            //need to be globally defined in order to be reset/cleared
            var contentBG;
            var contentBG2;
            var categoryPlane;
            var subcategoryPlane; 
            var columnTitlePlane;
            var shortTextPlane;
            var isFingerDown = false;
            
            //jQuery.getScript(folderArea + "meshwriter.js").then( console.log("meshwriter loaded") );
            
            var canvas = document.getElementById("canvas");

            canvas.addEventListener("pointerup", (evt) => onPointerUp(evt), false);
        /*
            canvas.addEventListener("pointerdown", (evt) => onPointerDown(evt), false);
            canvas.addEventListener("pointermove", (evt) => onPointerMove(evt), false);
        */

            var engine = new BABYLON.Engine(canvas, true);
            engine.setHardwareScalingLevel(1 / window.devicePixelRatio); 
            var scene = new BABYLON.Scene(engine);        
            scene.clearColor = new BABYLON.Color3.White;        

            var camera = new BABYLON.ArcRotateCamera("Camera",  0, 0, -10, new BABYLON.Vector3(0, 0, 0), scene);                        
            camera.radius = 100;        
            camera.cameraAcceleration = 0.005;
            camera.maxCameraSpeed = 2;        
            camera.attachControl(canvas, true);
            camera.noRotationConstraint= true;

            var cameraBox = BABYLON.MeshBuilder.CreateSphere("sphere", {diameterX: 12, diameterY: 12, diameterZ: 12});       
            cameraBox.position = new BABYLON.Vector3(-10, 10, 0);        
            cameraBox.material = matQ;
            cameraBox.isPickable = false;
            cameraBox.visibility = 0;
            cameraBox.checkCollisions = true;

            var cameraController = new CameraController;


        /*
            multiSpin( 
                        -60 * (Math.PI / 180), 
                        80 * (Math.PI / 180), 
                        new BABYLON.Vector3(0.2, 1, 0.2), 
                        30, 
                        new BABYLON.Vector3(0,0,0) 
                    );   

        */


            var light = new BABYLON.HemisphericLight("light", new BABYLON.Vector3(1, 1, -1), scene);
            var light = new BABYLON.HemisphericLight("light", new BABYLON.Vector3(-1, -1, 1), scene);//light backside

            var alt = "tx/TropicalSunnyDay1080";
            /*
            var bdata = document.querySelector('#body');
            if( bdata.dataset.alt != ""){
                var alt = "tx/" + bdata.dataset.alt; 
            }
            */

            var ease = new BABYLON.CubicEase();
            ease.setEasingMode(BABYLON.EasingFunction.EASINGMODE_EASEINOUT);
            
            //SKY
            var skybox = BABYLON.MeshBuilder.CreateBox("skyBox", {size:150}, scene);
            skybox.visibility = 1;
            var skyboxMaterial = new BABYLON.StandardMaterial("skyBox", scene);
            skyboxMaterial.backFaceCulling = false;
            skyboxMaterial.reflectionTexture = new BABYLON.CubeTexture(alt, scene);
            skyboxMaterial.reflectionTexture.coordinatesMode = BABYLON.Texture.SKYBOX_MODE;
            //skyboxMaterial.disableLighting = true;
            skyboxMaterial.diffuseColor = new BABYLON.Color3(0, 0, 0);
            skyboxMaterial.specularColor = new BABYLON.Color3(0, 0, 0);
            skybox.material = skyboxMaterial;


            var skyboxProject = BABYLON.MeshBuilder.CreateBox("skyBoxProject", {size:60}, scene);
            skyboxProject.visibility = 0;
            var skyboxProjectMaterial = new BABYLON.StandardMaterial("skyBoxProject", scene);
            skyboxProjectMaterial.backFaceCulling = false;
            skyboxProjectMaterial.reflectionTexture = new BABYLON.CubeTexture("tx/Project", scene);
            skyboxProjectMaterial.reflectionTexture.coordinatesMode = BABYLON.Texture.SKYBOX_MODE;
            skyboxProjectMaterial.reflectionTexture.rotationY += 0.01;
            //skyboxMaterial.disableLighting = true;
            skyboxProjectMaterial.diffuseColor = new BABYLON.Color3(0, 0, 0);
            skyboxProjectMaterial.specularColor = new BABYLON.Color3(0, 0, 0);
            skyboxProject.material = skyboxProjectMaterial;


            
            var matQ = new BABYLON.StandardMaterial("matQ1", scene);           
            matQ.backFaceCulling = true;
            matQ.reflectionTexture = new BABYLON.CubeTexture(alt, scene);
            matQ.reflectionTexture.coordinatesMode = BABYLON.Texture.PLANAR_MODE;
            matQ.diffuseColor = new BABYLON.Color3(0, 0, 0);
            matQ.specularColor = new BABYLON.Color3(0, 0, 0);        

            var matProject = new BABYLON.StandardMaterial("matQ1", scene);           
            matProject.backFaceCulling = true;
            matProject.reflectionTexture = new BABYLON.CubeTexture("tx/Project", scene);
            matProject.reflectionTexture.coordinatesMode = BABYLON.Texture.PLANAR_MODE;
            matProject.diffuseColor = new BABYLON.Color3(0, 0, 0);
            matProject.specularColor = new BABYLON.Color3(0, 0, 0);      
                    
            const center = BABYLON.MeshBuilder.CreateBox("boxzero", {size: 0.1}, scene);
            var whereYouAt = new BABYLON.Vector3(0, 0, 0); 
            center.position = whereYouAt;//later used as from in animation (from/to)
            center.visibility = 0.9;

            camera.target = center;
            camera.radius = 30;
            camera.alpha = -60 * (Math.PI / 180);
            camera.beta = 80 * (Math.PI / 180);
            camera.upVector = new BABYLON.Vector3(0, 1, 10 * (Math.PI / 180));//CUBE TILT              
        
            var matCross = new BABYLON.StandardMaterial("matQ1", scene);           
            matCross.backFaceCulling = true;
            matCross.reflectionTexture = new BABYLON.CubeTexture(alt, scene);
            matCross.reflectionTexture.coordinatesMode = BABYLON.Texture.PLANAR_MODE;
            matCross.reflectionTexture.blurKernel = 5;
            matCross.diffuseColor = new BABYLON.Color3(0, 0, 0);
            matCross.specularColor = new BABYLON.Color3(0, 0, 0);   
            matCross.reflectionTexture.level = 2;

            var b1 = BABYLON.MeshBuilder.CreateBox("b1", {height: 0.2, width: 0.2, depth: 2}, scene);        
            b1.material = matCross;
            b1.position.z = 1;
            var b2 = BABYLON.MeshBuilder.CreateBox("b2", {height: 2, width: 0.2, depth: 0.2}, scene);        
            b2.material = matCross;
            b2.position.y = -1;
            var b3 = BABYLON.MeshBuilder.CreateBox("b3", {height: 0.2, width: 2, depth: 0.2}, scene);        
            b3.material = matCross;
            b3.position.x = -0.9;
            var cross3D = BABYLON.Mesh.MergeMeshes([b1, b2, b3], true);   
            
            var line1 = BABYLON.MeshBuilder.CreateBox("b1", {height: 0.1, width: 0.1, depth: 40}, scene);        
            var matLine1 = new BABYLON.StandardMaterial("matLine1", scene);
            matLine1.diffuseColor  = new BABYLON.Color3.FromHexString('#01f9b0');        
            line1.material = matLine1;
            var line2 = BABYLON.MeshBuilder.CreateBox("b2", {height: 40, width: 0.1, depth: 0.1}, scene);        
            var matLine2 = new BABYLON.StandardMaterial("matLine1", scene);
            matLine2.diffuseColor = new BABYLON.Color3.FromHexString('#ff0326');
            line2.material = matLine2;
            var line3 = BABYLON.MeshBuilder.CreateBox("b3", {height: 0.1, width: 40, depth: 0.1}, scene);        
            var matLine3 = new BABYLON.StandardMaterial("matLine1", scene);
            matLine3.diffuseColor = new BABYLON.Color3.FromHexString('#fddd00');
            line3.material = matLine3;


            var faceUV = new BABYLON.Vector4(0, 0, 1, 1);

            var plane1a = BABYLON.MeshBuilder.CreatePlane("plane1a", {height: 20, width: 20, frontUVs: faceUV, backUVs: faceUV, sideOrientation: BABYLON.Mesh.DOUBLESIDE}, scene);        
            plane1a.position = new BABYLON.Vector3(-10, 10, 0);        
            plane1a.material = matQ;

            var plane1aMirror = BABYLON.MeshBuilder.CreatePlane("plane1a", {height: 20, width: 20, frontUVs: faceUV, backUVs: faceUV, sideOrientation: BABYLON.Mesh.DOUBLESIDE}, scene);        
            plane1aMirror.position = new BABYLON.Vector3(-10, 10, 0.01);        
            plane1aMirror.material = matProject;

            var plane1b = BABYLON.MeshBuilder.CreatePlane("plane1b", {height: 20, width: 20, frontUVs: faceUV, backUVs: faceUV, sideOrientation: BABYLON.Mesh.DOUBLESIDE}, scene);        
            plane1b.position = new BABYLON.Vector3(0, 10, 10);
            plane1b.rotation = new BABYLON.Vector3(0, 90 * (Math.PI / 180), 0);
            plane1b.material = matQ;
            
            var plane1bMirror = BABYLON.MeshBuilder.CreatePlane("plane1b", {height: 20, width: 20, frontUVs: faceUV, backUVs: faceUV, sideOrientation: BABYLON.Mesh.DOUBLESIDE}, scene);        
            plane1bMirror.position = new BABYLON.Vector3(-0.01, 10, 10);
            plane1bMirror.rotation = new BABYLON.Vector3(0, 90 * (Math.PI / 180), 0);
            plane1bMirror.material = matProject;
            
            var plane2a = BABYLON.MeshBuilder.CreatePlane("plane2a", {height: 20, width: 20, frontUVs: faceUV, backUVs: faceUV, sideOrientation: BABYLON.Mesh.DOUBLESIDE}, scene);        
            plane2a.position = new BABYLON.Vector3(-10, 0, -10);        
            plane2a.rotation = new BABYLON.Vector3(-90 * (Math.PI / 180), 0, 0);
            plane2a.material = matQ;

            var plane2aBack = BABYLON.MeshBuilder.CreatePlane("plane2a", {height: 20, width: 20, frontUVs: faceUV, backUVs: faceUV, sideOrientation: BABYLON.Mesh.DOUBLESIDE}, scene);        
            plane2aBack.position = new BABYLON.Vector3(-10, -0.01, -10);        
            plane2aBack.rotation = new BABYLON.Vector3(-90 * (Math.PI / 180), 0, 0);
            plane2aBack.material = matProject;
            
            var plane2b = BABYLON.MeshBuilder.CreatePlane("plane2b", {height: 20, width: 20, frontUVs: faceUV, backUVs: faceUV, sideOrientation: BABYLON.Mesh.DOUBLESIDE}, scene);        
            //plane2b backside is next to content
            plane2b.position = new BABYLON.Vector3(0, -10, -10);
            plane2b.rotation = new BABYLON.Vector3(0, 90 * (Math.PI / 180), 0);
            plane2b.material = matQ;

            var plane2birror = BABYLON.MeshBuilder.CreatePlane("plane2b", {height: 20, width: 20, frontUVs: faceUV, backUVs: faceUV, sideOrientation: BABYLON.Mesh.DOUBLESIDE}, scene);        
            //plane2b backside is next to content
            plane2birror.position = new BABYLON.Vector3(-0.01, -10, -10);
            plane2birror.rotation = new BABYLON.Vector3(0, 90 * (Math.PI / 180), 0);
            plane2birror.material = matProject;

            
            var plane3a = BABYLON.MeshBuilder.CreatePlane("plane3a", {height: 20, width: 20, frontUVs: faceUV, backUVs: faceUV, sideOrientation: BABYLON.Mesh.DOUBLESIDE}, scene);        
            plane3a.position = new BABYLON.Vector3(10, 0, 10);       
            plane3a.rotation = new BABYLON.Vector3(90 * (Math.PI / 180), 0, 0);
            plane3a.material = matQ;

            var plane3aMirror = BABYLON.MeshBuilder.CreatePlane("plane3a", {height: 20, width: 20, frontUVs: faceUV, backUVs: faceUV, sideOrientation: BABYLON.Mesh.DOUBLESIDE}, scene);        
            plane3aMirror.position = new BABYLON.Vector3(10, -0.01, 10);       
            plane3aMirror.rotation = new BABYLON.Vector3(90 * (Math.PI / 180), 0, 0);
            plane3aMirror.material = matProject;
            
            var plane3b = BABYLON.MeshBuilder.CreatePlane("plane3b", {height: 20, width: 20, frontUVs: faceUV, backUVs: faceUV, sideOrientation: BABYLON.Mesh.DOUBLESIDE}, scene);        
            plane3b.position = new BABYLON.Vector3(10, -10, 0);        
            plane3b.material = matQ;

            var plane3bMirror = BABYLON.MeshBuilder.CreatePlane("plane3b", {height: 20, width: 20, frontUVs: faceUV, backUVs: faceUV, sideOrientation: BABYLON.Mesh.DOUBLESIDE}, scene);        
            plane3bMirror.position = new BABYLON.Vector3(10, -10, 0.01);        
            plane3bMirror.material = matProject;

            center.actionManager = new BABYLON.ActionManager(scene);
            center.actionManager.registerAction(new BABYLON.InterpolateValueAction(BABYLON.ActionManager.OnPickTrigger, camera, "target", center.position, 500));
            center.actionManager.registerAction(new BABYLON.InterpolateValueAction(BABYLON.ActionManager.OnPickTrigger, camera, "radius", 50, 500));        

            //moved to parse content 

            // set default view     
                    
            cameraController.moveTo('HOME');              

            addControls(scene, camera);

            var renderLoop = function () {
                scene.render();
                //move camera center
                //center.position = new BABYLON.Vector3(0, 0, 0);
                //centerTarget
                //.position.x
                //.position.y
                //.position.z = ;
                //if(){

                //}
            }
            engine.runRenderLoop(renderLoop);        

            window.addEventListener("resize", function () {
                engine.resize();
            });

            function loadJSON(callback) {
                var xobj = new XMLHttpRequest();
                xobj.overrideMimeType("application/json");
                xobj.open('GET', '/api/cubes/1/generate-json', true);
                xobj.onreadystatechange = function () {
                    if (xobj.readyState == 4 && xobj.status == "200") {                    
                        callback(xobj.responseText);
                    }
                };
                xobj.send(null);  
            }     

            function initParseContent( d ){
                cmsdata = d;
                //HOME
                cross3D.actionManager = new BABYLON.ActionManager(scene);
                cross3D.actionManager.registerAction(new BABYLON.ExecuteCodeAction(BABYLON.ActionManager.OnPickTrigger, function() {

                    if(camera.activeAnimations == 0) {
                        if(cameraController.currentDestination == "PROJECT") { 
                            setTimeout(function(){ 
                                let easing = new BABYLON.CubicEase();
                                easing.setEasingMode(BABYLON.EasingFunction.EASINGMODE_EASEOUT);
                                BABYLON.Animation.CreateAndStartAnimation('spinTo', skyboxProject, 'visibility', 60, 60, 1, 0, 0, easing);                     
                            }, 500);
                        }
                        navigateCube("HOME");
                    }
                }));  
                //WORK
                plane1a.actionManager = new BABYLON.ActionManager(scene);
                plane1a.actionManager.registerAction(new BABYLON.ExecuteCodeAction(BABYLON.ActionManager.OnPickTrigger, function() {
                    console.log("1a");
                    navigateCube("WORK");
                }));   
                plane2a.actionManager = new BABYLON.ActionManager(scene);
                plane2a.actionManager.registerAction(new BABYLON.ExecuteCodeAction(BABYLON.ActionManager.OnPickTrigger, function() {
                    console.log("2a");
                    navigateCube("WORK");
                }));            
                //LEARN
                plane3a.actionManager = new BABYLON.ActionManager(scene);
                plane3a.actionManager.registerAction(new BABYLON.ExecuteCodeAction(BABYLON.ActionManager.OnPickTrigger, function() {
                    console.log("3a");
                    navigateCube("LEARN");
                }));    
                plane1b.actionManager = new BABYLON.ActionManager(scene);
                plane1b.actionManager.registerAction(new BABYLON.ExecuteCodeAction(BABYLON.ActionManager.OnPickTrigger, function() {
                    console.log("1b");
                    navigateCube("LEARN");
                })); 
                //PLAY
                plane2b.actionManager = new BABYLON.ActionManager(scene);
                plane2b.actionManager.registerAction(new BABYLON.ExecuteCodeAction(BABYLON.ActionManager.OnPickTrigger, function() {                                
                    console.log("2b");
                    navigateCube("PLAY");                
                }));    
                plane3b.actionManager = new BABYLON.ActionManager(scene);
                plane3b.actionManager.registerAction(new BABYLON.ExecuteCodeAction(BABYLON.ActionManager.OnPickTrigger, function() {                
                    console.log("3b");
                    navigateCube("PLAY");
                })); 

                
                var dynamicTexPlay = new BABYLON.DynamicTexture("DynamicTexturePlay", {width:2000, height:2000}, scene);
                var texContextPlay = dynamicTexPlay.getContext();
                var materialPlay  = new BABYLON.StandardMaterial("MatPlay", scene);                    
                materialPlay.diffuseTexture = dynamicTexPlay;            
                materialPlay.reflectionTexture = new BABYLON.MirrorTexture("ImgPlay", 400, scene, true);
                materialPlay.reflectionTexture.mirrorPlane = new BABYLON.Plane(0, -1.0, 0, -2.0);
                materialPlay.reflectionTexture.renderList = [skybox, skyboxProject];
                materialPlay.reflectionTexture.level = 0.2;

                var menuPlayPlane = BABYLON.MeshBuilder.CreatePlane("menuPlayPlane", {height: 8, width: 8}, scene);        
                menuPlayPlane.isPickable = false
                menuPlayPlane.position = new BABYLON.Vector3(4.5, -4.5, -0.2); 
                menuPlayPlane.rotation = new BABYLON.Vector3(0, 0, 90 * (Math.PI / 180));
                menuPlayPlane.material = materialPlay;  

                //ALEX CODE SUPPORT//

                    menuPlayPlane.computeWorldMatrix(true);
                    var glass_worldMatrix = menuPlayPlane.getWorldMatrix();
                    var glass_vertexData = menuPlayPlane.getVerticesData("normal");
                    var glassNormal = new BABYLON.Vector3(glass_vertexData[0], glass_vertexData[1], glass_vertexData[2]);	
                    glassNormal = new BABYLON.Vector3.TransformNormal(glassNormal, glass_worldMatrix)
                    var reflector = new BABYLON.Plane.FromPositionAndNormal(menuPlayPlane.position, glassNormal.scale(-1));
                    materialPlay.reflectionTexture.mirrorPlane = reflector;
                    
                    var mirrorPlay = BABYLON.MeshBuilder.CreatePlane("menuWorkPlaneMirror", {height: 20, width: 20}, scene); 
                    mirrorPlay.position = new BABYLON.Vector3(0.01, -10, -10); 
                    mirrorPlay.rotation = new BABYLON.Vector3(0, -90 * (Math.PI / 180), 90 * (Math.PI / 180));     
                    mirrorPlay.material = new BABYLON.StandardMaterial("matQ1", scene);           
                    mirrorPlay.material.backFaceCulling = false;
                    mirrorPlay.material.reflectionTexture = new BABYLON.MirrorTexture("mirror", 1024, scene, true);
                    mirrorPlay.material.diffuseColor = new BABYLON.Color3(0, 0, 0);
                    
                    mirrorPlay.computeWorldMatrix(true);
                    var glass_worldMatrix = mirrorPlay.getWorldMatrix();
                    var glass_vertexData = mirrorPlay.getVerticesData("normal");
                    var glassNormal = new BABYLON.Vector3(glass_vertexData[0], glass_vertexData[1], glass_vertexData[2]);	
                    glassNormal = new BABYLON.Vector3.TransformNormal(glassNormal, glass_worldMatrix)
                    var reflector = new BABYLON.Plane.FromPositionAndNormal(mirrorPlay.position, glassNormal.scale(-1));
                    
                    mirrorPlay.material.reflectionTexture.mirrorPlane = reflector;
                    mirrorPlay.material.reflectionTexture.renderList = [skybox, skyboxProject, cross3D, line1, line2, line3, menuPlayPlane, plane3b];
                    mirrorPlay.material.reflectionTexture.level = 0.5;

                //..//
                
                var dynamicTexWork = new BABYLON.DynamicTexture("DynamicTextureWork", {width:2000, height:2000}, scene);
                var texContextWork = dynamicTexWork.getContext();
                var materialWork  = new BABYLON.StandardMaterial("MatWork", scene);                    
                materialWork.diffuseTexture = dynamicTexWork;
                materialWork.reflectionTexture = new BABYLON.MirrorTexture("ImgWork", 400, scene, true);
                materialWork.reflectionTexture.mirrorPlane = new BABYLON.Plane(0, -1.0, 0, -2.0);
                materialWork.reflectionTexture.renderList = [skybox. skyboxProject];
                materialWork.reflectionTexture.level = 0.2;
                
                var menuWorkPlane = BABYLON.MeshBuilder.CreatePlane("menuWorkPlane", {height: 8, width: 8}, scene);        
                menuWorkPlane.isPickable = false
                menuWorkPlane.position = new BABYLON.Vector3(-4.5, 0.2, -4.5);        
                menuWorkPlane.rotation = new BABYLON.Vector3(90 * (Math.PI / 180), 0, 0);
                menuWorkPlane.material = materialWork;

                //ALEX CODE SUPPORT//

                    menuWorkPlane.computeWorldMatrix(true);
                    var glass_worldMatrix = menuWorkPlane.getWorldMatrix();
                    var glass_vertexData = menuWorkPlane.getVerticesData("normal");
                    var glassNormal = new BABYLON.Vector3(glass_vertexData[0], glass_vertexData[1], glass_vertexData[2]);	
                    glassNormal = new BABYLON.Vector3.TransformNormal(glassNormal, glass_worldMatrix)
                    var reflector = new BABYLON.Plane.FromPositionAndNormal(menuWorkPlane.position, glassNormal.scale(-1));
                    materialWork.reflectionTexture.mirrorPlane = reflector;
                    
                    var mirrorWork = BABYLON.MeshBuilder.CreatePlane("menuWorkPlaneMirror", {height: 20, width: 20}, scene); 
                    mirrorWork.position = new BABYLON.Vector3(-10, 10, 0); 
                    mirrorWork.material = new BABYLON.StandardMaterial("matQ1", scene);           
                    mirrorWork.material.backFaceCulling = true;
                    mirrorWork.material.reflectionTexture = new BABYLON.MirrorTexture("mirror", 1024, scene, true);
                    mirrorWork.material.diffuseColor = new BABYLON.Color3(0, 0, 0);
                    
                    mirrorWork.computeWorldMatrix(true);
                    var glass_worldMatrix = mirrorWork.getWorldMatrix();
                    var glass_vertexData = mirrorWork.getVerticesData("normal");
                    var glassNormal = new BABYLON.Vector3(glass_vertexData[0], glass_vertexData[1], glass_vertexData[2]);	
                    glassNormal = new BABYLON.Vector3.TransformNormal(glassNormal, glass_worldMatrix)
                    var reflector = new BABYLON.Plane.FromPositionAndNormal(mirrorWork.position, glassNormal.scale(-1));
                    
                    mirrorWork.material.reflectionTexture.mirrorPlane = reflector;
                    mirrorWork.material.reflectionTexture.renderList = [skybox, skyboxProject,cross3D, line1, line2, line3, menuWorkPlane, plane2a];
                    mirrorWork.material.reflectionTexture.level = 0.5;
                
                //..//

                var dynamicTexLearn = new BABYLON.DynamicTexture("DynamicTextureLearn", {width:2000, height:2000}, scene);
                var texContextLearn = dynamicTexLearn.getContext();
                var materialLearn = new BABYLON.StandardMaterial("MatLearn", scene);                    
                materialLearn.diffuseTexture = dynamicTexLearn;
                materialLearn.reflectionTexture = new BABYLON.MirrorTexture("ImgLearn", 400, scene, true);
                materialLearn.reflectionTexture.mirrorPlane = new BABYLON.Plane(0, -1.0, 0, -2.0);
                materialLearn.reflectionTexture.renderList = [skybox, skyboxProject];
                materialLearn.reflectionTexture.level = 0.2;

                var menuLearnPlane = BABYLON.MeshBuilder.CreatePlane("menuLearnPlane", {height: 8, width: 8}, scene);        
                menuLearnPlane.isPickable = false
                menuLearnPlane.position = new BABYLON.Vector3( 0.2, 4.5, 4.5);        
                menuLearnPlane.rotation = new BABYLON.Vector3(0, -90 * (Math.PI / 180), 90 * (Math.PI / 180));
                menuLearnPlane.material = materialLearn;   

                //ALEX CODE SUPPORT//

                    menuLearnPlane.computeWorldMatrix(true);
                    var glass_worldMatrix = menuLearnPlane.getWorldMatrix();
                    var glass_vertexData = menuLearnPlane.getVerticesData("normal");
                    var glassNormal = new BABYLON.Vector3(glass_vertexData[0], glass_vertexData[1], glass_vertexData[2]);	
                    glassNormal = new BABYLON.Vector3.TransformNormal(glassNormal, glass_worldMatrix)
                    var reflector = new BABYLON.Plane.FromPositionAndNormal(menuLearnPlane.position, glassNormal.scale(-1));
                    materialLearn.reflectionTexture.mirrorPlane = reflector;
                    
                    var mirrorLearn = BABYLON.MeshBuilder.CreatePlane("menuWorkPlaneMirror", {height: 20, width: 20}, scene); 
                    mirrorLearn.position = new BABYLON.Vector3(10, 0, 10);       
                    mirrorLearn.rotation = new BABYLON.Vector3(90 * (Math.PI / 180), 0, 0);
                    mirrorLearn.material = new BABYLON.StandardMaterial("matQ1", scene);           
                    mirrorLearn.material.backFaceCulling = true;
                    mirrorLearn.material.reflectionTexture = new BABYLON.MirrorTexture("mirror", 1024, scene, true);
                    mirrorLearn.material.diffuseColor = new BABYLON.Color3(0, 0, 0);

                    mirrorLearn.computeWorldMatrix(true);
                    var glass_worldMatrix = mirrorLearn.getWorldMatrix();
                    var glass_vertexData = mirrorLearn.getVerticesData("normal");
                    var glassNormal = new BABYLON.Vector3(glass_vertexData[0], glass_vertexData[1], glass_vertexData[2]);	
                    glassNormal = new BABYLON.Vector3.TransformNormal(glassNormal, glass_worldMatrix)
                    var reflector = new BABYLON.Plane.FromPositionAndNormal(mirrorLearn.position, glassNormal.scale(-1));

                    mirrorLearn.material.reflectionTexture.mirrorPlane = reflector;
                    mirrorLearn.material.reflectionTexture.renderList = [skybox, skyboxProject,cross3D,line1, line2, line3, menuLearnPlane, plane1b];
                    mirrorLearn.material.reflectionTexture.level = 0.5;

                //..//

                var font = "bold 360px Otto Attac Type";
                var fontmenu = "normal 90px Verdana";

                //PLAY
                var imgPlay = new Image();
                imgPlay.src = getPage("PLAY")["background_visual"];
                imgPlay.onload = function () {
                    texContextPlay.drawImage(imgPlay, 0, 0, 2000, 2000);  
                    texContextPlay.textAlign = "right";
                    dynamicTexPlay.update();
                    dynamicTexPlay.drawText("PLAY", 1000, 1900, font, "#377b45", null, true, true);
                    
                    for (let i = 0; i < getPage('PLAY')["projects"].length; i++) {
                        var verticalspacing = 120 * i;
                        dynamicTexPlay.drawText(getPage("PLAY")["projects"][i]["title"], 1900, (160 + verticalspacing), fontmenu, "#377b45", null, true, true);

                        var menubutt = BABYLON.MeshBuilder.CreatePlane( ("menubutt" + i), { width: 7.6, height: 0.5, faceColors: BABYLON.Color3.Red() }, scene);
                        menubutt.rotation = new BABYLON.Vector3(0, 0, 90 * (Math.PI / 180));
                        menubutt.position = new BABYLON.Vector3((1 + (i / 2)), -4.7, -0.1);                    
                        menubutt.actionManager = new BABYLON.ActionManager(scene);
                        menubutt.actionManager.registerAction(new BABYLON.ExecuteCodeAction(BABYLON.ActionManager.OnPickTrigger, function() {
                            openCube("PLAY", getPage("PLAY")["projects"][i]);
                        }));                     
                    }
                }

                //WORK
                var imgWork = new Image();
                imgWork.src = folderArea + getPage("WORK")["background_visual"];
                imgWork.onload = function () {
                    texContextWork.drawImage(imgWork, 0, 0, 2000, 2000);  
                    texContextWork.textAlign = "right";
                    dynamicTexWork.update();                          
                    dynamicTexWork.drawText("WORK", 1350, 1900, font, "#2554d9", null, true, true);                                  

                    for (let i = 0; i < getPage("WORK")["projects"].length; i++) {
                        var verticalspacing = 120 * i;
                        dynamicTexWork.drawText(getPage("WORK")["projects"][i]["title"], 1900, (160 + verticalspacing), fontmenu, "#2554d9", null, true, true);

                        var menubutt = BABYLON.MeshBuilder.CreatePlane( ("menubutt" + i), { width: 7.6, height: 0.5, faceColors: BABYLON.Color3.Red() }, scene);
                        menubutt.rotation = new BABYLON.Vector3(90 * (Math.PI / 180), 0, 0);
                        menubutt.position = new BABYLON.Vector3(-4.7, 0.1, (-1 - (i / 2)));                    
                        menubutt.actionManager = new BABYLON.ActionManager(scene);
                        menubutt.actionManager.registerAction(new BABYLON.ExecuteCodeAction(BABYLON.ActionManager.OnPickTrigger, function() {
                            openCube("WORK", getPage("WORK")["projects"][i]);
                        }));  
                    }
                }

                //LEARN
                var imgLearn = new Image();
                imgLearn.src = folderArea + getPage("LEARN")["background_visual"];
                imgLearn.onload = function () {
                    texContextLearn.drawImage(imgLearn, 0, 0, 2000, 2000);
                    texContextLearn.textAlign = "right";
                    dynamicTexLearn.update();
                    dynamicTexLearn.drawText("LEARN", 1250, 1900, font, "#c00029", null, true, true);
                    
                    for (let i = 0; i < getPage("LEARN")["projects"].length; i++) {
                        var verticalspacing = 120 * i;
                        dynamicTexLearn.drawText(getPage("LEARN")["projects"][i]["title"], 1900, (160 + verticalspacing), fontmenu, "#c00029", null, true, true);

                        var menubutt = BABYLON.MeshBuilder.CreatePlane( ("menubutt" + i), { width: 7.6, height: 0.5, faceColors: BABYLON.Color3.Red() }, scene);
                        menubutt.rotation = new BABYLON.Vector3(0, -90 * (Math.PI / 180), 90 * (Math.PI / 180));
                        menubutt.position = new BABYLON.Vector3(0.1, 4.7, (1 + (i / 2)));                    
                        menubutt.actionManager = new BABYLON.ActionManager(scene);
                        menubutt.actionManager.registerAction(new BABYLON.ExecuteCodeAction(BABYLON.ActionManager.OnPickTrigger, function() {
                            openCube("LEARN", getPage("LEARN")["projects"][i]);
                        })); 
                    }
                }

                var frametop = document.createElement("frametop");
                frametop.setAttribute("id", "frametop");
                frametop.innerHTML = "<a class=\"workmenu\" href=\"javascript:navigateCube('WORK')\">WORK</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class=\"playmenu\" href=\"javascript:navigateCube('PLAY')\">PLAY</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class=\"learnmenu\" href=\"javascript:navigateCube('LEARN')\">LEARN</a>";
                frametop.innerHTML += "<div id='logo'><a class=\"homemenu\" href=\"javascript:navigateCube('HOME')\">uni_verse_studio</a></div>";            
                document.body.appendChild(frametop);

                var frameleft = document.createElement("frameleft");
                frameleft.setAttribute("id", "frameleft");
                document.body.appendChild(frameleft);

                var frameright = document.createElement("frameright");
                frameright.setAttribute("id", "frameright");
                document.body.appendChild(frameright);

                var framebottom = document.createElement("framebottom");
                framebottom.setAttribute("id", "framebottom");
                framebottom.innerHTML = "<a href=\"javascript:navigateCube('CONTACT')\">CONTACT</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:navigateCube('ABOUT')\">ABOUT</a>";
                document.body.appendChild(framebottom);                                     
            }

            function removeHTML(i) {
                document.getElementById(i).outerHTML = ""
            }

            function getPage(page_name) {
                for(let index = 0; index < cmsdata[0]["pages"].length; index++){
                    if (cmsdata[0]["pages"][index]["name"] == page_name)
                        return cmsdata[0]["pages"][index];
                }
            }

            function navigateCube(destination){     

                cameraController.moveTo(destination);

                /*

                //multiSpin >>> alpha beta upVector radius moveCenter
                if(destination == "HOME"){
                    multiSpin( 
                        -60 * (Math.PI / 180), 
                        80 * (Math.PI / 180), 
                        new BABYLON.Vector3(0.2, 1, 0.2), 
                        30, 
                        new BABYLON.Vector3(0,0,0) 
                    );
                }
                else if(destination == "WORK"){
                    multiSpin( 
                        -120 * (Math.PI / 180), 
                        60 * (Math.PI / 180), 
                        new BABYLON.Vector3(0, 1, 0.2), 
                        22, 
                        new BABYLON.Vector3(0,0,0)                     
                    );
                }
                else if(destination == "PLAY"){
                    multiSpin( 
                        -60 * (Math.PI / 180), 
                        100 * (Math.PI / 180), 
                        new BABYLON.Vector3(-0.9, 1, -1.6), 
                        22, 
                        new BABYLON.Vector3(0,0,0)                     
                    );
                }
                else if(destination == "LEARN"){

                    camera.spinTo("alpha", -60 * (Math.PI / 180), 60);
                    camera.spinTo("beta", 80 * (Math.PI / 180), 60);
                    camera.spinTo("upVector", new BABYLON.Vector3(0.2, 1, 0.2), 160);
                    camera.spinTo("radius",30, 120);  

                    setTimeout(function(){ 
                        moveCenter( new BABYLON.Vector3(0,0,0)  ); 
                        camera.spinTo("alpha", 2.24965964, 60);
                        camera.spinTo("beta", 0.4782, 60);
                        camera.spinTo("radius", 22, 120);   
                        setTimeout(function(){ 
                            camera.spinTo("upVector", new BABYLON.Vector3(0.8320502, 0.5547, 0), 160);
                        }, 1200);
                    }, 1200);
                }
                else 

                */
                
                if(destination == "CONTACT"){                                
                    openTEXT( cmsdata["pages"]["CONTACT"][0]["text"] );
                }
                else if(destination == "ABOUT"){                
                    openTEXT( cmsdata["pages"]["ABOUT"][0]["text"] );
                }            
            }

            function openCube(c, dataobj){

                if(camera.activeAnimations == 0) {
                    cameraController.moveTo('PROJECT');
                    var crdnts = [9,9,4];
                    //moveCenter( new BABYLON.Vector3(-9, 3, -5.5) );

                    if(c == "WORK"){
                        openContent(crdnts, dataobj, "WORK", "#2554d9");
                    }
                    else if(c == "LEARN"){
                        openContent(crdnts, dataobj, "LEARN", "#c00029");
                    }
                    else if(c == "PLAY"){
                        openContent(crdnts, dataobj, "PLAY", "#377b45");
                    }
                }
            }

            function openContent(crdnts, dataobj, tit, txtColor){
                console.log(dataobj);
                console.log(crdnts);

                setTimeout(function(){ 
                    let easing = new BABYLON.CubicEase();
                    easing.setEasingMode(BABYLON.EasingFunction.EASINGMODE_EASEINOUT);
                    BABYLON.Animation.CreateMergeAndStartAnimation('spinTo', skyboxProject, 'visibility', 60, 35, 0, 1, 0, easing);                     
                }, 1500);
            
                var projRotation = new BABYLON.Vector3(-90 * (Math.PI / 180), -180 * (Math.PI / 180), 0);            
                descriptionText = dataobj["text"];//openTEXT
                //DISPOSAL            
                if(contentBG){
                    contentBG.dispose();
                }
                if(categoryPlane){                                                                         
                    categoryPlane.dispose();     
                }
                if(subcategoryPlane){
                    subcategoryPlane.actionManager.unregisterAction( subcategoryPlane.actionManager.actions[0] );//werkt niet?
                    subcategoryPlane.dispose(); 
                }                                                                     
                var disposethis = scene.getMeshesByTags("deleteMe");
                for (var index = 0; index < disposethis.length; index++) {
                    disposethis[index].dispose();
                }

                var dynamicTex = new BABYLON.DynamicTexture("dynamicTex3", {width:2000, height:2000}, scene);            
                var texContext = dynamicTex.getContext();                       
                texContext.textAlign = "right";
                dynamicTex.update();  
                var material  = new BABYLON.StandardMaterial("material4", scene);                                
                material.diffuseTexture = dynamicTex;
                material.diffuseTexture.hasAlpha = true;
                material.alpha = 0.9;
                material.useAlphaFromDiffuseTexture = true;

                categoryPlane = BABYLON.MeshBuilder.CreatePlane("shortTextPlane", {width: 20, height: 20}, scene);        
                categoryPlane.isPickable = true;
                categoryPlane.position = new BABYLON.Vector3(-10, -0.02, -10); 
                categoryPlane.rotation = new BABYLON.Vector3(-90 * (Math.PI / 180), -90 * (Math.PI / 180), 0);                  
                categoryPlane.material = material;  
                //categoryPlane.scaling = new BABYLON.Vector3(0.7,0.7,0.7);

                BABYLON.Tags.AddTagsTo(categoryPlane, "deleteMe");                                
                dynamicTex.drawText(tit, 1940, 120, "bold 85px Otto Attac Type", txtColor, "transparent", true);
                dynamicTex.drawText(dataobj["title"], 1940, 160, "normal 30px Helvetica", txtColor, "transparent", true);    


                                    
                //COLUMNS//            
                var grp = new BABYLON.TransformNode();  

                let contentLength = 0;          

                for(let c = 0; c < dataobj["visuals"].length; c++){
                    console.log('diocaneee');

                    var columnwidth = dataobj["visuals"][c]["width"]; 
                    var columnname = dataobj["visuals"][c]["name"]; 
                    var offsetH = 0;
                    var offsetV = 1; 

                    if(c == 0){
                        offsetH = 3;
                    }
                    else if(c == 1){
                        offsetH = 4 + dataobj["visuals"][c]["width"];
                    }
                    else if (c == 2){
                        offsetH = 5 + dataobj["visuals"][0]["width"] + dataobj["visuals"][1]["width"];
                    }
                    
                    contentLength = contentLength + columnwidth;
                    
                    //LET OP UNITS versus PIXELS
                    //CUBE is 20 UNITS
                    
                    var dynamicTex3 = new BABYLON.DynamicTexture("dynamicTex3", {width:600, height:100}, scene);            
                    var texContext3 = dynamicTex3.getContext();                       
                    var material3  = new BABYLON.StandardMaterial("material3", scene);                                
                    material3.diffuseTexture = dynamicTex3;
                    material3.diffuseTexture.hasAlpha = true;
                    material3.alpha = 1;
                    material3.useAlphaFromDiffuseTexture = true;
                    columnTitlePlane = BABYLON.MeshBuilder.CreatePlane("columnTitlePlane" + c, {width: 6, height: 1}, scene);        
                    columnTitlePlane.isPickable = false;
                    columnTitlePlane.position = new BABYLON.Vector3(3 + offsetH, -.6, -0.2);// <> , ^ , \/                       
                    columnTitlePlane.material = material3;  
                    BABYLON.Tags.AddTagsTo(columnTitlePlane, "deleteMe");
                    columnTitlePlane.parent = grp;        
                    dynamicTex3.drawText(dataobj["visuals"][c]["name"], 10, 50, "normal 60px Helvetica", txtColor, "transparent", true);
                    //dynamicTex3.scaling = new BABYLON.Vector3(5,5,5);
                    
                    //dynamicTex.drawText(dataobj["visuals"][c]["name"], 10, 50, "bold 40px Helvetica", txtColor, "transparent", true);   
                    //impossible to rotate text within texture, so if we want it to be a whole, text orientation of column names should be vertical to

                    for(let i = 0; i < dataobj["visuals"][c]["medium_objects"].length; i++){
                        var imagewidth = dataobj["visuals"][c]["medium_objects"][i]["width"]/10;
                        var imageheight = dataobj["visuals"][c]["medium_objects"][i]["height"]/10;
                        var planewidth = columnwidth;
                        var planeratio = imagewidth / columnwidth;
                        var planeheight = imageheight / planeratio;                    
                        
                        var matImg = new BABYLON.StandardMaterial("texIMG", scene);
                        console.log(dataobj["visuals"][c]["medium_objects"][i]["path"]);
                        matImg.diffuseTexture = new BABYLON.Texture( folderArea + dataobj["visuals"][c]["medium_objects"][i]["path"] , scene);
                        matImg.specularColor = new BABYLON.Color3(0, 0, 0);
                        matImg.backFaceCulling = false;                    
                        const planeImg = BABYLON.MeshBuilder.CreatePlane("planeImg" + i, { width: planewidth, height: planeheight }, scene);
                        BABYLON.Tags.AddTagsTo(planeImg, "deleteMe");
                        planeImg.position = new BABYLON.Vector3((planewidth / 2) + offsetH, (-1 * (planeheight / 2)) - offsetV, -0.1);                     
                        planeImg.material = matImg;
                        planeImg.parent = grp;                             
                        planeImg.actionManager = new BABYLON.ActionManager(scene);
                        planeImg.actionManager.registerAction(new BABYLON.ExecuteCodeAction(BABYLON.ActionManager.OnPickTrigger, function() {
                            openIMG( dataobj["visuals"][c]["medium_objects"][i] );
                        }));           
                        
                        offsetV += planeheight + 1;                    
                    }
                }

                var dynamicTex4 = new BABYLON.DynamicTexture("dynamicTex4", {width:2000, height:2000}, scene);            
                var texContext4 = dynamicTex4.getContext();                       
                texContext4.textAlign = "left";
                dynamicTex4.update();  
                var material4  = new BABYLON.StandardMaterial("material4", scene);                                
                material4.diffuseTexture = dynamicTex4;
                material4.diffuseTexture.hasAlpha = true;
                material4.alpha = 0.9;
                material4.useAlphaFromDiffuseTexture = true;
                shortTextPlane = BABYLON.MeshBuilder.CreatePlane("shortTextPlane", {width: 20, height: 20}, scene);        
                shortTextPlane.isPickable = true;
                shortTextPlane.position = new BABYLON.Vector3((contentLength * 2) + (offsetH/2), -11, -0.1);
                // shortTextPlane.rotation = new BABYLON.Vector3(0, 180 * (Math.PI / 180), 0);                  
                shortTextPlane.material = material4;  
                shortTextPlane.parent = grp;                             
                BABYLON.Tags.AddTagsTo(shortTextPlane, "deleteMe");  

                
                let paragraph = '';
                let lineVerticalStart = 20;
                dataobj["description"].match(/(\w+)/g).forEach((word, idx) => {                
                    paragraph += ' ' + word;
                    if((idx+1)%9 == 0) {
                        dynamicTex4.drawText(paragraph, 0, lineVerticalStart, "normal 26px Helvetica", txtColor, "transparent", true);
                        paragraph = '';
                        lineVerticalStart = lineVerticalStart + 30;
                    }
                })
                dynamicTex4.drawText(paragraph, 0, lineVerticalStart, "normal 26px Helvetica", txtColor, "transparent", true);            

                // dynamicTex4.drawText(dataobj["description"] + " (click to read more..)", 0, 20, "normal 26px Helvetica", txtColor, "transparent", true);

                shortTextPlane.actionManager = new BABYLON.ActionManager(scene);
                shortTextPlane.actionManager.registerAction(new BABYLON.ExecuteCodeAction(BABYLON.ActionManager.OnPickTrigger, function() {                
                    openTEXT( descriptionText );
                })); 

                grp.rotation = projRotation;
                grp.scaling = new BABYLON.Vector3(0.5,0.5,0.5);
                grp.position  = new BABYLON.Vector3(-0.6,0,-0.4);
            }

            function openTEXT(txt){
                console.log("TEXT: " + txt);
                var msg = document.createElement("div");
                msg.setAttribute("id", "msg");
                //msg.setAttribute("onclick", "removeHTML('msg')");
                var addHTML = "<div id='curtain' onclick=\"removeHTML('msg')\"></div>";            
                addHTML += "<div id='msgwindow'>" + txt + "<div id=\"closeX\"><a href=\"javascript:removeHTML('msg')\"></a></div></div>";
                msg.innerHTML = addHTML;
                document.body.appendChild(msg);
            }

            function openIMG(iObj){                        
                if( iObj["enlargefirst"] == true ){                
                    var ratioWidth = iObj["width"] / window.innerWidth;
                    var ratioHeight = iObj["height"] / window.innerHeight;                
                    var aspectRatio = iObj["width"] / iObj["height"];                
                    
                    if(ratioWidth > ratioHeight){                    
                        var w = window.innerWidth - 66;
                        var h = Math.floor(w / aspectRatio) - 66;
                    }
                    else{                    
                        var h = window.innerHeight - 66;
                        var w = Math.floor(h * aspectRatio) - 66;
                    }                
                    
                    var openedIMG = document.createElement("div");
                    openedIMG.setAttribute("id", "layover");                    
                    var innermost = "<div id='curtain' onclick=\"removeHTML('layover')\"></div>";
                    innermost += "<div id='openedIMG' style=\"margin-left: " + Math.floor((-1 * w) / 2) + "px; margin-top: " + Math.floor((-1 * h) / 2) + "px; width: " + w + "px; height:" + h + "px;\">";                
                    innermost += "<img src='" + folderArea + iObj["path"] + "'>";
                    innermost += "</div>";
                    openedIMG.innerHTML = innermost;
                    document.body.appendChild(openedIMG); 

                }
                else if( iObj["video"] == "vimeo" ){
                    var ratioWidth = iObj["videowidth"] / window.innerWidth;
                    var ratioHeight = iObj["videoheight"] / window.innerHeight;                
                    var aspectRatio = iObj["videowidth"] / iObj["videoheight"];                
                    
                    if(ratioWidth > ratioHeight){                    
                        var w = window.innerWidth - 66;
                        var h = Math.floor(w / aspectRatio) - 66;
                    }
                    else{                                        
                        var h = window.innerHeight - 66;
                        var w = Math.floor(h * aspectRatio) - 66;
                    }                 
                    
                    var embedVimeo = document.createElement("div");
                    embedVimeo.setAttribute("id", "layover");                    
                    var innermost = "<div id='curtain' onclick=\"removeHTML('layover')\"></div>";
                    innermost += "<div id='embedVimeo' style=\"margin-left: " + Math.floor((-1 * w) / 2) + "px; margin-top: " + Math.floor((-1 * h) / 2) + "px; width: " + w + "px; height:" + h + "px;\">";
                    innermost += "<iframe src='https://player.vimeo.com/video/" + iObj["link"] + "' width='" + w + "' height='" + h + "' frameborder='0' allow='autoplay; fullscreen; picture-in-picture' allowfullscreen></iframe>";
                    innermost += "</div>";
                    embedVimeo.innerHTML = innermost;
                    document.body.appendChild(embedVimeo); 
                }
                else if( iObj["video"] == "youtube" ){
                    console.log("YOUTUBE CODE:  " + iObj["link"] ); 
                }
                else if( iObj["link"] != ""){
                    console.log("SOON TO BE OPEN:  " + iObj["link"] ); 
                }
            }

            /* Alex - Moved this one up
            BABYLON.ArcRotateCamera.prototype.spinTo = function (whichprop, targetval, speed) {            
                BABYLON.Animation.CreateAndStartAnimation('spinTo', this, whichprop, speed, 120, this[whichprop], targetval, 0, ease);                     
            }
            */

            function multiSpin(a, b, uv3, r, v3){
        /*

                camera.spinTo("alpha", -60 * (Math.PI / 180), 60);
                camera.spinTo("beta", 80 * (Math.PI / 180), 60);
                camera.spinTo("upVector", new BABYLON.Vector3(0.2, 1, 0.2), 160);
                camera.spinTo("radius",30, 120);  

                setTimeout(function(){ 
                    moveCenter( v3 ); 
                    camera.spinTo("alpha", a, 60);
                    camera.spinTo("beta", b, 60);
                    camera.spinTo("upVector", uv3, 160);
                    camera.spinTo("radius", r, 120);    
                }, 1200);

            */
            }                

            function moveCenter(t) {     
                BABYLON.Animation.CreateAndStartAnimation('movecenter', center, "position", 60, 120, whereYouAt, t, 0, ease); 
                whereYouAt = t;
            }   

            // Collision detection homepage
            scene.registerBeforeRender(function () {
                            
                var offset = 0;

                // 2a work
                // 1a work mirror
                // 1b learn
                // 3a learn mirror
                // 3b play
                // 2b play mirror

                cameraBox.position = camera.position;
                camera.upperAlphaLimit = null;
                camera.lowerAlphaLimit = null;
                camera.upperBetaLimit = null;
                camera.lowerBetaLimit =  null;

                // check if animating
                if(camera.activeAnimations == 0) {

                    camera.attachControl(canvas, true);

                    if(cameraController.currentDestination == "PROJECT") { 

                        camera.lowerBetaLimit = 120 * (Math.PI / 180);
                        camera.lowerAlphaLimit = 80 * (Math.PI / 180);
                        camera.upperBetaLimit = 140 * (Math.PI / 180);
                        camera.upperAlphaLimit = 100 * (Math.PI / 180);


                        //if(camera.beta != 90 * (Math.PI / 180)) 
                        //   cameraController.moveTo('PROJECT');

                        /*
                            camera.spinTo("alpha", 90 * (Math.PI / 180), 60);
                            camera.spinTo("beta", 129 * (Math.PI / 180), 60);
                        */
                    }

                    if(cameraController.currentDestination == "PLAY") { 
                    
                        if (cameraBox.intersectsMesh(plane2a) && cameraBox.intersectsMesh(plane2b)) {
                            camera.lowerBetaLimit =  1;
                            console.log("2a2b")
                        }
                        else if (cameraBox.intersectsMesh(plane3a) && cameraBox.intersectsMesh(plane1b)) {
                            camera.upperBetaLimit = camera.beta;
                            camera.upperAlphaLimit = camera.alpha;
                            console.log("3a1b")
                        }
                        else if (cameraBox.intersectsMesh(plane1a) && cameraBox.intersectsMesh(plane1b)) {
                            camera.upperBetaLimit = camera.beta;
                            camera.upperAlphaLimit =camera.alpha;
                            console.log("1a21b")
                        }
                        else if (cameraBox.intersectsMesh(plane2a)) {
                            camera.upperAlphaLimit = camera.alpha;
                            camera.upperBetaLimit = camera.beta;
                            console.log("2a");
                        } else if (cameraBox.intersectsMesh(plane1a)) {
                            camera.upperBetaLimit = camera.beta;
                            console.log("1a")
                        } else if (cameraBox.intersectsMesh(plane1b)) {
                            camera.upperAlphaLimit = camera.alpha;
                            camera.lowerBetaLimit = 1.9;
                            console.log("1b")
                        } else if (cameraBox.intersectsMesh(plane3b)) {
                            camera.upperBetaLimit = camera.beta;
                            camera.lowerAlphaLimit = camera.alpha;
                            console.log("3b")
                        } else if (cameraBox.intersectsMesh(plane3a)) {
                            camera.upperBetaLimit = camera.beta;
                            camera.lowerAlphaLimit = camera.alpha;
                            console.log("23")
                        } else if (cameraBox.intersectsMesh(plane2b)) {
                            camera.lowerAlphaLimit = camera.alpha;
                            camera.lowerBetaLimit =  1.4;
                            console.log("2b")
                        } 
                    }

                    if(cameraController.currentDestination == "WORK" || cameraController.currentDestination == "HOME") { 
                    
                        if (cameraBox.intersectsMesh(plane2a) && cameraBox.intersectsMesh(plane1a)) {
                            camera.upperBetaLimit =  camera.beta;
                            camera.lowerAlphaLimit =camera.alpha;
                            // work hoek
                            console.log("2a2b")
                        }
                        else if (cameraBox.intersectsMesh(plane3a) && cameraBox.intersectsMesh(plane1b)) {
                            camera.upperBetaLimit = camera.beta;
                            camera.upperAlphaLimit = camera.alpha;
                            console.log("3a1b")
                        }
                        else if (cameraBox.intersectsMesh(plane1a) && cameraBox.intersectsMesh(plane1b)) {
                            camera.lowerBetaLimit = camera.beta;
                            camera.lowerAlphaLimit =camera.alpha;
                            console.log("1a21b")
                        }
                        else if (cameraBox.intersectsMesh(plane2a)) {
                            camera.upperAlphaLimit = camera.alpha;
                            camera.upperBetaLimit = camera.beta;
                            console.log("2a"); // work
                        } else if (cameraBox.intersectsMesh(plane1a)) {
                            camera.lowerAlphaLimit = camera.alpha;
                            camera.upperBetaLimit =  camera.beta;
                            camera.lowerBetaLimit =  1.4;
                            console.log("1a")
                        } else if (cameraBox.intersectsMesh(plane1b)) {
                            camera.upperAlphaLimit = camera.alpha;
                            camera.lowerBetaLimit = camera.beta;
                            console.log("1b")
                        } else if (cameraBox.intersectsMesh(plane3b)) {
                            camera.upperBetaLimit = camera.beta;
                            camera.upperAlphaLimit = camera.alpha;
                            console.log("3b")
                        } else if (cameraBox.intersectsMesh(plane3a)) {
                            camera.upperBetaLimit =  camera.beta;
                            camera.upperAlphaLimit = camera.alpha;
                            console.log("23")
                        } else if (cameraBox.intersectsMesh(plane2b)) {
                            camera.lowerAlphaLimit = camera.alpha;
                            camera.upperBetaLimit =  2.5;
                        } 
                    }

                    if(cameraController.currentDestination == "LEARN") { 
                        
                        if (cameraBox.intersectsMesh(plane2a) && cameraBox.intersectsMesh(plane1a)) {
                            camera.upperBetaLimit =  camera.beta;
                            camera.lowerAlphaLimit =camera.alpha;
                            // work hoek
                            console.log("2a2b")
                        }
                        else if (cameraBox.intersectsMesh(plane3a) && cameraBox.intersectsMesh(plane1b)) {
                            camera.upperBetaLimit = camera.beta;
                            camera.upperAlphaLimit = camera.alpha;
                            console.log("3a1b")
                        }
                        else if (cameraBox.intersectsMesh(plane1a) && cameraBox.intersectsMesh(plane1b)) {
                            camera.upperBetaLimit = camera.beta;
                            camera.lowerAlphaLimit =camera.alpha;
                            console.log("1a21b")
                        }
                        else if (cameraBox.intersectsMesh(plane2a)) {
                            camera.upperAlphaLimit = camera.alpha;
                            camera.upperBetaLimit = camera.beta;
                            console.log("2a"); // work
                        } else if (cameraBox.intersectsMesh(plane1a)) {
                            camera.lowerAlphaLimit = camera.alpha;
                            camera.upperBetaLimit =  camera.beta;
                            camera.lowerBetaLimit =  1.4;
                            console.log("1a")
                        } else if (cameraBox.intersectsMesh(plane1b)) {
                            camera.lowerAlphaLimit = camera.alpha;
                            camera.upperBetaLimit = 0.9;
                            console.log("1b")
                        } else if (cameraBox.intersectsMesh(plane3b)) {
                            camera.upperBetaLimit = camera.beta;
                            camera.upperAlphaLimit = camera.alpha;
                            console.log("3b")
                        } else if (cameraBox.intersectsMesh(plane3a)) {
                            camera.upperBetaLimit =  camera.beta;
                            camera.lowerAlphaLimit = camera.alpha;
                            console.log("23")
                        } else if (cameraBox.intersectsMesh(plane2b)) {
                            camera.lowerAlphaLimit = camera.alpha;
                            camera.upperBetaLimit =  camera.beta;
                            console.log("2b")
                        } 
                    }
                }
                
            });

            function addControls(scene, camera) {
                camera.inertia = 0.85;//smoothness / easing op mouse drag
                camera.lowerRadiusLimit = 15; //zoom beperking
                camera.upperRadiusLimit = 25;

                camera.angularSensibilityX = camera.angularSensibilityY = 1000; // gevoelighiedh draaien

                var rotationMode = false;

                const plane =
                    BABYLON.Plane.FromPositionAndNormal(BABYLON.Vector3.Zero(), BABYLON.Axis.Y);    
                const inertialPanning = BABYLON.Vector3.Zero();  // doet iets met zoom snelheid scroll
                
                const wheelPrecisionFn = () => {
                    camera.wheelPrecision = 1 / camera.radius * 1000;
                };

                const zoomFn = (p,e) => {
                    const delta = zoomWheel(p,e,camera);
                    zooming(delta, scene, camera, plane, inertialPanning);
                }

                const prvScreenPos = BABYLON.Vector2.Zero();

                scene.onPointerObservable.add(zoomFn, BABYLON.PointerEventTypes.POINTERWHEEL);
                scene.onBeforeRenderObservable.add(wheelPrecisionFn);

                //stop context menu showing on canvas right click
                scene.getEngine().getRenderingCanvas().addEventListener("contextmenu", (e) => {
                    e.preventDefault();
                });
            }

            var onPointerMove = function(evt, pickResult) {
                /*
                console.log(camera.activeAnimations);
                if(isFingerDown) {
                    for (anim of cameraController.activeAnimationsArray) {
                        anim.stop();
                    }
                } 
                */
            }

            var onPointerDown = function(evt, pickResult) {

                isFingerDown = true;
            }
            // back to orginal state
            var onPointerUp = function(evt, pickResult) {

                isFingerDown = false;

                /*
                for (anim of cameraController.activeAnimationsArray) {
                    anim.stop();
                }
                */

                setTimeout(function(){ 
                    if(camera.activeAnimations == 0) {
                        if(cameraController.currentDestination == "PROJECT") { 
                            if(camera.beta != 90 * (Math.PI / 180)) 
                                cameraController.moveTo('PROJECT');
                        }
                    }
                }, 100);
            };

            function zoomWheel(p, e, camera) {
                const event = p.event;
                event.preventDefault();
                let delta = 0;
                if (event.deltaY) {
                    delta = -event.deltaY;
                } else if (event.wheelDelta) {
                    delta = event.wheelDelta;
                } else if (event.detail) {
                    delta = -event.detail;
                }
                delta /= camera.wheelPrecision;
                return delta;
            }

            function zooming(delta, scene, camera, plane, ref) {

                if (camera.radius - camera.lowerRadiusLimit < 1 && delta > 0) {
                    return;
                } else if (camera.upperRadiusLimit - camera.radius < 1 && delta < 0) {
                    return;
                }
                const inertiaComp = 1 - camera.inertia;
                if (camera.radius - (camera.inertialRadiusOffset + delta) / inertiaComp <
                    camera.lowerRadiusLimit) {
                    delta = (camera.radius - camera.lowerRadiusLimit) * inertiaComp - camera.inertialRadiusOffset;
                } else if (camera.radius - (camera.inertialRadiusOffset + delta) / inertiaComp >
                        camera.upperRadiusLimit) {
                    delta = (camera.radius - camera.upperRadiusLimit) * inertiaComp - camera.inertialRadiusOffset;
                }
                camera.inertialRadiusOffset += delta;
            }
            function hexToColor3(str, c){       
                var r = parseInt( str.substr(1,2), 16);
                var g = parseInt( str.substr(3,2), 16);
                var b = parseInt( str.substr(5,2), 16);            
                var colorThree = new Array( (r / 255), (g / 255), (b / 255) );
                return colorThree[c];            
                //new BABYLON.Color3( hexToColor3("#019db6", 0), hexToColor3("#019db6", 1), hexToColor3("#019db6", 2) ); 
                //include #
            }                     
        </script>

    </body>
</html>