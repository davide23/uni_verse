class CameraController
{
    currentDestination = "HOME";
    activeAnimations = 0;
    activeAnimationsArray = [];

    constructor() {

        BABYLON.ArcRotateCamera.prototype.destination = this.currentDestination;
        BABYLON.ArcRotateCamera.prototype.activeAnimations = this.activeAnimations;
        BABYLON.ArcRotateCamera.prototype.activeAnimationsArray = this.activeAnimationsArray;

        BABYLON.ArcRotateCamera.prototype.spinTo = function (whichprop, targetval, speed) { 
            let resetVal;
            if(whichprop == "alpha")   resetVal = -60 * (Math.PI / 180);
            if(whichprop == "beta")  resetVal = 80 * (Math.PI / 180);
            if(whichprop == "upVector")  resetVal = new BABYLON.Vector3(0.2, 1, 0.2);
            if(whichprop == "radius")  resetVal = 30;

            // Check if there is already an animation running
            if(BABYLON.ArcRotateCamera.prototype.activeAnimations < 4) {
                if(BABYLON.ArcRotateCamera.prototype.destination != "HOME" && BABYLON.ArcRotateCamera.prototype.destination != "PROJECT") {
                    setTimeout(async () => {
                        let easing = new BABYLON.CubicEase();
                        easing.setEasingMode(BABYLON.EasingFunction.EASINGMODE_EASEINOUT);
                        let animation = BABYLON.Animation.CreateAndStartAnimation('spinTo', this, whichprop, speed, 120, this[whichprop], resetVal, 0, easing);                     
                        BABYLON.ArcRotateCamera.prototype.activeAnimations++;
                        BABYLON.ArcRotateCamera.prototype.activeAnimationsArray.push(animation);
                        await animation.waitAsync();
                        setTimeout(async () => {
                            let animation2 = BABYLON.Animation.CreateAndStartAnimation('spinTo', this, whichprop, speed, 120, this[whichprop], targetval, 0, easing);
                            BABYLON.ArcRotateCamera.prototype.activeAnimationsArray.push(animation2);
                            await animation2.waitAsync();
                            BABYLON.ArcRotateCamera.prototype.activeAnimations =  BABYLON.ArcRotateCamera.prototype.activeAnimations - 1;       
                        }, 1);     
                        
                    }, 1);
                }
                else {
                    let easing = new BABYLON.CubicEase();
                    easing.setEasingMode(BABYLON.EasingFunction.EASINGMODE_EASEINOUT);
                    BABYLON.ArcRotateCamera.prototype.activeAnimations++;
                    setTimeout(async () => {
                        let animation = BABYLON.Animation.CreateMergeAndStartAnimation('spinTo', this, whichprop, speed, 120, this[whichprop], targetval, 0, easing);                     
                        BABYLON.ArcRotateCamera.prototype.activeAnimationsArray.push(animation);
                        await animation.waitAsync();
                        BABYLON.ArcRotateCamera.prototype.activeAnimations =  BABYLON.ArcRotateCamera.prototype.activeAnimations - 1;
                    }, 1);     
                }
            }
        }        

    }

    moveTo(destination){

        //this.stopAnimations();

        if(BABYLON.ArcRotateCamera.prototype.activeAnimations == 0) {

            camera.detachControl(canvas);
            
            if(destination == "HOME"){
                this.multiSpin( 
                    -60 * (Math.PI / 180), 
                    80 * (Math.PI / 180), 
                    new BABYLON.Vector3(0.2, 1, 0.2), 
                    30, 
                    new BABYLON.Vector3(0,0,0) 
                );
            }
            else if(destination == "WORK"){
                this.multiSpin( 
                    -120 * (Math.PI / 180), 
                    60 * (Math.PI / 180), 
                    new BABYLON.Vector3(0, 1, 0.2), 
                    22, 
                    new BABYLON.Vector3(0,0,0)                     
                );
            }
            else if(destination == "PLAY"){
                this.multiSpin( 
                    -60 * (Math.PI / 180), 
                    100 * (Math.PI / 180), 
                    new BABYLON.Vector3(-0.9, 1, -1.6), 
                    22, 
                    new BABYLON.Vector3(0,0,0)                     
                );
            }
            else if(destination == "LEARN"){
                camera.spinTo("alpha", 2.24965964, 60);
                camera.spinTo("beta", 0.4782, 80);
                camera.spinTo("radius", 22, 60);  
                camera.spinTo("upVector", new BABYLON.Vector3(0.8320502, 0.5547, 0), 50);
            }
            else if(destination == "PROJECT"){

                // excception
                this.currentDestination = destination;
                BABYLON.ArcRotateCamera.prototype.destination = this.currentDestination;
                
                camera.spinTo("alpha", 90 * (Math.PI / 180), 60);
                camera.spinTo("beta", 129 * (Math.PI / 180), 60);
                camera.spinTo("upVector", new BABYLON.Vector3(-0.0, 1., 0.65), 60);
                camera.spinTo("radius", 20, 60);   
                this.moveCenter( new BABYLON.Vector3(-9, 3, -5.5) ); 
            }

            this.currentDestination = destination;
            BABYLON.ArcRotateCamera.prototype.destination = this.currentDestination;

        } else {
            setTimeout(function(){ this.moveTo(destination) }.bind(this), 1000);
        }
        
    }     


    multiSpin(a, b, uv3, r, v3){
        camera.spinTo("alpha", a, 60);
        camera.spinTo("beta", b, 60);
        camera.spinTo("upVector", uv3, 60);
        camera.spinTo("radius", r, 60);            
        moveCenter( v3 ); 
    }       

    moveCenter(t) {     
        BABYLON.Animation.CreateAndStartAnimation('movecenter', center, "position", 60, 120, whereYouAt, t, 0, ease); 
        whereYouAt = t;
    }   


    stopAnimations() {     
        for (var anim of this.activeAnimationsArray) {
            anim.stop();
        }
    }   
}