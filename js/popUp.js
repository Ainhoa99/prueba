const open = document.getElementById("btn-valorar");
const openClase = document.getElementById("enlace-clase-nueva");
const modal_container = document.getElementById("modal_container");
const close = document.getElementById("close");

if (open) {
  open.addEventListener("click", () => {
    modal_container.classList.add("show");
  });
}
if (openClase) {
  openClase.addEventListener("click", () => {
    modal_container.classList.add("show");
  });
}

close.addEventListener("click", () => {
  modal_container.classList.remove("show");
});
