/**
 * Fonction qui permet de remplacer les caractères spéciaux par des caractères normaux
 * Fonction qui nous permettra d'accéder à l'image du cocktail fournie par notre professeur
 * avec le nom du cocktail, en enlevant les caractères spéciaux
 * @param nomcocktail nom du cocktail avec caractères spéciaux
 * @returns {string} nom du cocktail sans caractère spécial
 */
function name_cocktail(cocktail) {
    var str = cocktail.replaceAll(" ", "_");
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

/**
 * Fonction permettant de faire une requête XMLHttp
 * permettant de savoir si un fichier existe dans un dossier se trouvant dans l'aborescence du site
 * @param urlToFile chemin du fichier
 * @returns {boolean} vrai si le fichier existe, faux sinon
 */
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