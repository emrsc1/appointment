const listGroup=document.querySelectorAll(".list-group div");

listGroup.forEach(function(item){
item.addEventListener("dblclick",function(){

    listGroup.forEach(function(btn){
         btn.classList.remove("active");
    });
    this.classList.add("active");
  preventDefault();
});
});
addEventListener("DOMContentLoaded", () => {
  const historyState = history.state || {};
  const { searchParamAdded } = historyState;
  if (!searchParamAdded && window.location.search.includes("?search=true")) {
    const updatedUrl = window.location.href.replace("?search=true", "");
    history.replaceState({ ...historyState, searchParamAdded: true }, "", updatedUrl);
  }
});