var uuid = document.getElementById("skin_container").getAttribute("name");
let skinViewer = new skinview3d.SkinViewer({
    domElement: document.getElementById("skin_container"),
    height: 500,
    width: 292.5,
    skinUrl: "https://crafatar.com/skins/" + uuid + ".png"
});
let control = new skinview3d.createOrbitControls(skinViewer);
skinViewer.animation = new skinview3d.CompositeAnimation();
let walk = skinViewer.animation.add(skinview3d.WalkingAnimation);
walk.speed = 1.5;
let rotate = skinViewer.animation.add(skinview3d.RotatingAnimation);
