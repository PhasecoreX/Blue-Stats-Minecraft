var uuid = document.getElementById("skin_container").getAttribute("name");
let skinViewer = new skinview3d.SkinViewer({
    domElement: document.getElementById("skin_container"),
    height: 500,
    width: 292.5,
    skinUrl: "https://crafatar.com/skins/" + uuid + ".png"
});
let control = new skinview3d.createOrbitControls(skinViewer);
let walk = skinViewer.animations.add(skinview3d.WalkingAnimation);
let rotate = skinViewer.animations.add(skinview3d.RotatingAnimation);
