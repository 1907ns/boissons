function name_str(str1) {
    // remplace les caractères spéciaux
    var str = str1.replaceAll(" ", "_");
    str = str.replaceAll("'", "");
    str = str.replaceAll("à", "a");
    str = str.replaceAll("ä", "a");
    str = str.replaceAll("é", "e");
    str = str.replaceAll("è", "e");
    str = str.replaceAll("ë", "e");
    str = str.replaceAll("ê", "e");
    str = str.replaceAll("ï", "i");
    str = str.replaceAll("î", "i");
    str = str.replaceAll("ô", "o");
    str = str.replaceAll("ö", "o");
    str = str.replaceAll("û", "u");
    str = str.replaceAll("ü", "u");
    str = str.replaceAll("ù", "u");
    str = str.replaceAll("ç", "c");
    str = str.replaceAll("ñ", "n");

    return str;
}

function doesFileExist(urlToFile) {
    var xhr = new XMLHttpRequest();
    xhr.open('HEAD', urlToFile, false);
    xhr.send();

    if (xhr.status == "404") {
        return false;
    } else {
        return true;
    }
}