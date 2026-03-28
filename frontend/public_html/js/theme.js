document.addEventListener("DOMContentLoaded", () => {

    const month = new Date().getMonth() + 1;

    let theme = "spring";

    if (month >= 3 && month <= 5) theme = "spring";
    else if (month >= 6 && month <= 8) theme = "summer";
    else if (month >= 9 && month <= 11) theme = "fall";
    else theme = "winter";

    const link = document.createElement("link");
    link.rel = "stylesheet";
    link.href = `/css/themes/${theme}.css`;

    document.head.appendChild(link);
});