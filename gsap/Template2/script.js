document.addEventListener("DOMContentLoaded", function () {
    // Ensure GSAP and ScrollTrigger are available
    if (typeof gsap !== "undefined" && typeof ScrollTrigger !== "undefined") {
        gsap.registerPlugin(ScrollTrigger);

        // Define different movement values for desktop and mobile
        // then kaning silang naa sa ubos is e as is lang ni sila gamit ni siya para sa mobile for positioning 
        const isMobile = window.innerWidth <= 768;
        const leftXValues = isMobile ? [-1500, -1500, -500] : [-800, -900, -400];
        const rightXValues = isMobile ? [1500, 1500, 500] : [800, 900, 400];
        const leftRotationValues = isMobile ? [-45, -40, -50] : [-30, -20, -35];
        const rightRotationValues = isMobile ? [45, 40, 50] : [30, 20, 35];
        const yValues = isMobile ? [200, -300, -700] : [100, -150, -400];

        gsap.utils.toArray(".middle_wra").forEach((row, index) => { //kaning middle_wra kay mo ni ang nag kupot sa left_con ug sa right con
            const cardLeft = row.querySelector(".left_con");
            const cardRight = row.querySelector(".right_con");

            gsap.fromTo(cardLeft,
                { x: 0, y: 0, rotation: 0 },
                {
                    x: leftXValues[index],
                    rotation: leftRotationValues[index],
                    scrollTrigger: {
                        trigger: ".middle", // kaning middle kay mao ni ang main container or mother ni midle wra
                        start: "top 10%", //e adjust lang ni kung kanusa mo start ang animation nig ka scroll
                        end: "90% bottom",// then sa kani pud kanusa ma end ang animation
                        scrub: true,
                        onUpdate: (self) => {
                            const progress = self.progress;
                            gsap.set(cardLeft, {
                                x: progress * leftXValues[index],
                                y: progress * yValues[index],
                                rotation: progress * leftRotationValues[index]
                            });
                        },
                    },
                }
            );

            gsap.fromTo(cardRight,
                { x: 0, y: 0, rotation: 0 },
                {
                    x: rightXValues[index],
                    rotation: rightRotationValues[index],
                    scrollTrigger: {
                        trigger: ".middle", // kaning middle kay mao ni ang main container or mother ni midle wra
                        start: "top 10%", //e adjust lang ni kung kanusa mo start ang animation nig ka scroll
                        end: "90% bottom",// then sa kani pud kanusa ma end ang animation
                        scrub: true,
                        onUpdate: (self) => {
                            const progress = self.progress;
                            gsap.set(cardRight, {
                                x: progress * rightXValues[index],
                                y: progress * yValues[index],
                                rotation: progress * rightRotationValues[index]
                            });
                        },
                    },
                }
            );
        });
    } else {
        console.error("GSAP or ScrollTrigger not found.");
    }
});

