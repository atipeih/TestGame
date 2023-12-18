<?php
 echo $this->html->script('phaser');
?>
<style>
    
</style>
<script>
const createDice = (x, y, scene, duration = 3000) => {

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
            this.load.image("pin", 'assets/pin.png');
            this.load.image("tile", 'assets/tile.png');
        }

        create() {
            const tiles = {
                1:{
                    x:100,
                    y:200,
                },
                2:{
                    x:220,
                    y:200,
                },
                3:{
                    x:340,
                    y:200,
                },
                4:{
                    x:460,
                    y:200,
                },
                5:{
                    x:580,
                    y:200,
                },
                6:{
                    x:700,
                    y:200,
                },
                7:{
                    x:820,
                    y:200,
                },
            }

            let tileObj = {}

            const index = {
                1:{
                    x:0.75,
                    y:0.75,
                },
                2:{
                    x:0.25,
                    y:0.75,
                },
                3:{
                    x:0.75,
                    y:0.25,
                },
                4:{
                    x:0.25,
                    y:0.25,
                },
                5:{
                    x:0.5,
                    y:0.25,
                },
            }
            let player = {
                1:2, 
                2:1, 
                3:1,
                4:2,
                5:2,
            } 

            // 自分より小さいキーの数字で勝つ同じマスに止まっているプレイヤー数 + 1
            let getIndex = function(playerNo) {
                var ind = 1;
                for(let i = 1;i < playerNo;i++) {
                    if(player[i] == player[playerNo]) {
                        ind++
                    } else {
                        continue;
                    }
                }
                return ind;
    }
            for(let i = 1; i < 8;i++) {
               tileObj[i] = this.add.image(tiles[i]['x'], tiles[i]['y'], 'tile').setOrigin(.5, .3).setScale(0.33, 0.33);
            }
            let pin1 = this.add.image(tileObj[player[1]].x, tileObj[player[1]].y, 'pin').setOrigin(index[getIndex(1)]['x'],index[getIndex(1)]['y'] ).setScale(0.25, 0.25);
            let pin2 = this.add.image(tileObj[player[2]].x, tileObj[player[2]].y, 'pin').setOrigin(index[getIndex(2)]['x'],index[getIndex(2)]['y'] ).setScale(0.25, 0.25);
            let pin3 = this.add.image(tileObj[player[3]].x, tileObj[player[3]].y, 'pin').setOrigin(index[getIndex(3)]['x'],index[getIndex(3)]['y'] ).setScale(0.25, 0.25);
            let pin4 = this.add.image(tileObj[player[4]].x, tileObj[player[4]].y, 'pin').setOrigin(index[getIndex(4)]['x'],index[getIndex(4)]['y'] ).setScale(0.25, 0.25);
            let pin5 = this.add.image(tileObj[player[5]].x, tileObj[player[5]].y, 'pin').setOrigin(index[getIndex(5)]['x'],index[getIndex(5)]['y'] ).setScale(0.25, 0.25);

            
            
        //     const dice1 = createDice(300, 300, this, 1000);
        //     const dice2 = createDice(900, 300, this, 1300);
        //     const dice3 = createDice(1500, 300, this, 1600);

        // // Text object to show the dice value
        // const textDiceValue = this.add.text(this.scale.width / 2, this.scale.height / 2, '0', { fontFamily: 'Arial Black', fontSize: 74, color: '#c51b7d' });
        // textDiceValue.setStroke('#de77ae', 16)
        //     .setScale(0);

        // this.sum = 0;


        // this.diceroll = this.input.keyboard.on('keydown-ENTER', () => {
        //     this.sum = 0;
        //     dice1((diceValue) => {
        //         this.sum += diceValue;
        //     });
        //     dice2((diceValue) => {
        //         this.sum += diceValue;
        //     });
        //     dice3((diceValue) => {
        //         this.sum += diceValue;
        //     });
        // });
        // this.sumValue = this.add.text(960, 700, this.sum, {fontSize:120, fontFamily:'Bold Italic', stroke:'#fff', strokeThickness:3, fill:'#fff'}).setOrigin(0.5, 0.5);

        }

        update() {
            // this.sumValue.setText(this.sum);
        }
    }




    let config = {
        type:Phaser.AUTO,
        width:1920,
        height:1080,
        scene:[
            Main,
        ],
        parent:'game',
    }

    let game = new Phaser.Game(config);
</script>
<div id="game"></div>