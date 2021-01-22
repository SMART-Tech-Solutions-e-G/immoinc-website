if (document.querySelector(".edit-real-estate-announcement")) {
    document.querySelector("#freeFromOption").addEventListener("change", realEstateFreeFromSelectUpdate);
    realEstateFreeFromSelectUpdate();
}

function realEstateFreeFromSelectUpdate() {
    if (document.querySelector("#freeFromOption").selectedIndex === 0)
        document.querySelector("#freeFrom").style.display = "none";
    else document.querySelector("#freeFrom").style.display = "";
}
