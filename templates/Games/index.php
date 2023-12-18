<?php
 echo $this->html->script('phaser');
?>
<style>
    
</style>
<script>
const createDice = (x, y, scene, duration = 1000) => {

let diceIsRolling = false;

const dice = scene.add.mesh(x, y, "dice-albedo");
const shadowFX = dice.postFX.addShadow(0, 0, 0.006, 2, 0x111111, 10, .8);

dice.addVerticesFromObj("dice-obj", 0.25);
dice.panZ(6);

dice.modelRotation.x = Phaser.Math.DegToRad(0);
dice.modelRotation.y = Phaser.Math.DegToRad(-90);

return (callback) => {
    if (!diceIsRolling) {
        diceIsRolling = true;
        const diceRoll = Phaser.Math.Between(1, 6);

        // Shadow
        scene.add.tween({
            targets: shadowFX,
            x: -8,
            y: 10,
            duration: duration -250,
            ease: "Sine.easeInOut",
            yoyo: true,
        });

        scene.add.tween({
            targets: dice,
            from: 0,
            to: 1,
            duration: duration,
            onUpdate: () => {
                dice.modelRotation.x -= .02;
                dice.modelRotation.y -= .08;
            },
            onComplete: () => {
                switch (diceRoll) {
                    case 1:
                        dice.modelRotation.x = Phaser.Math.DegToRad(0);
                        dice.modelRotation.y = Phaser.Math.DegToRad(-90);
                        break;
                    case 2:
                        dice.modelRotation.x = Phaser.Math.DegToRad(90);
                        dice.modelRotation.y = Phaser.Math.DegToRad(0);
                        break;
                    case 3:
                        dice.modelRotation.x = Phaser.Math.DegToRad(180);
                        dice.modelRotation.y = Phaser.Math.DegToRad(0);
                        break;
                    case 4:
                        dice.modelRotation.x = Phaser.Math.DegToRad(180);
                        dice.modelRotation.y = Phaser.Math.DegToRad(180);
                        break;
                    case 5:
                        dice.modelRotation.x = Phaser.Math.DegToRad(-90);
                        dice.modelRotation.y = Phaser.Math.DegToRad(0);
                        break;
                    case 6:
                        dice.modelRotation.x = Phaser.Math.DegToRad(0);
                        dice.modelRotation.y = Phaser.Math.DegToRad(90);
                        break;
                }
            },
            ease: "Sine.easeInOut",
        });

        // Intro dice
        scene.add.tween({
            targets: [dice],
            scale: 1.2,
            duration: duration - 200,
            yoyo: true,
            ease: Phaser.Math.Easing.Quadratic.InOut,
            onComplete: () => {
                dice.scale = 1;
                if (callback !== undefined) {
                    diceIsRolling = false;
                    callback(diceRoll);
                }
            }
        });
    } else {
        console.log("Is rolling");
    }
}

}

    class Main extends Phaser.Scene
    {
        constructor() {
            super({key:'Main'});
        }
        preload() {
            this.load.image("dice-albedo", "assets/dice-albedo.png");
            this.load.obj("dice-obj", "assets/dice.obj");
        }

        create() {
            const dice = createDice(this.scale.width / 2, this.scale.height / 2, this, 1000);

        // Text object to show the dice value
        const textDiceValue = this.add.text(this.scale.width / 2, this.scale.height / 2, '0', { fontFamily: 'Arial Black', fontSize: 74, color: '#c51b7d' });
        textDiceValue.setStroke('#de77ae', 16)
            .setScale(0);

        this.input.keyboard.on('keydown-ENTER', () => {
            dice((diceValue) => {
                console.log('Dice value ', diceValue);

                // Show the dice value
                textDiceValue.text = diceValue;
                textDiceValue.setOrigin(0.5);
                textDiceValue.setPosition(this.scale.width / 2, this.scale.height / 2);

                // this.add.tween({
                //     targets: textDiceValue,
                //     scale: 1,
                //     duration: 1000,
                //     ease: Phaser.Math.Easing.Bounce.Out,
                //     onComplete: () => {
                //         this.add.tween({
                //             targets: [textDiceValue],
                //             scale: 0,
                //             delay: 1000,
                //             duration: 1000,
                //             ease: Phaser.Math.Easing.Bounce.Out,
                //         });
                //     }
                // });
            });
        });

        // Text information. Is not important
        const rect = this.add.rectangle(0, this.scale.height - 50, this.scale.width, 50, 0x000000, 1)
            .setAlpha(.9)
            .setOrigin(0);
        this.add.text(rect.getCenter().x, rect.getCenter().y, 'Click to roll dice', {
            font: '20px Courier',
            fill: '#00ff00',
        }).setOrigin(0.5);
        }
    }




    let config = {
        type:Phaser.AUTO,
        width:800,
        height:600,
        scene:[
            Main,
        ],
        parent:'game',
    }

    let game = new Phaser.Game(config);
</script>
<div id="game"></div>