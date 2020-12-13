if (document.querySelector(".create-real-estate-announcement")) {
    document.querySelector("#freeFromOption").addEventListener("change", realEstateFreeFromSelectUpdate);
    realEstateFreeFromSelectUpdate();
}

function realEstateFreeFromSelectUpdate() {
    if (document.querySelector("#freeFromOption").selectedIndex === 0)
        document.querySelector("#freeFrom").style.display = "none";
    else document.querySelector("#freeFrom").style.display = "";
}

function realEstateTypeSelectUpdate() {
    if (document.querySelector("#type").selectedIndex === 0) {
        document.querySelector("#floorWrapper").style.display = "none";
        document.querySelector("#floor").setAttribute("disabled", true);
        document.querySelector("#constructionYear").removeAttribute("disabled");
        document.querySelector("#constructionYearWrapper").style.display = "";
    } else {
        document.querySelector("#floorWrapper").style.display = "";
        document.querySelector("#floor").removeAttribute("disabled");
        document.querySelector("#constructionYear").setAttribute("disabled", true);
        document.querySelector("#constructionYearWrapper").style.display = "none";
    }
}

if (document.querySelector(".create-real-estate-announcement")) {
    document.querySelector("#type").addEventListener("change", realEstateTypeSelectUpdate);
    realEstateTypeSelectUpdate();
}
