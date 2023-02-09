/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

import { Tooltip, Toast, Popover } from 'bootstrap';

// start the Stimulus application
import './bootstrap';





    window.onload =() => {
        let optionLieu = "<option value=''>-- Sélectionnez une ville au dessus --</option>\n";
        let selectLieux = document.getElementById("sortie_lieu");
        selectLieux.innerHTML = optionLieu;
    }

    let oVille = document.getElementById("sortie_ville");
    oVille.addEventListener("change", searchLieu);

    function searchLieu() {
        let iVilleId = oVille.value;



        if(iVilleId != 0){
            fetch('http://127.0.0.1:8000/lieu/'+iVilleId,
                {
                    headers: {
                        'Content-Type': 'application/json',
                        'Access-Control-Allow-Origin': '*'
                    },
                    method: "GET",
                    mode: "no-cors",
                    credentials: "same-origin",

                }
            )
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Problème - code d'état HTTP : " + response.status);
                    }

                    return response.json();
                })
                .then(

                    (body) => {
                        let optionLieu = "<option value=''>-- Sélectionnez un lieu --</option>\n";


                        body.forEach((value) => {
                            optionLieu += "<option value='"+value.id+"'>"+value.nom+"</option>\n";
                        });

                        let oLieux = document.getElementById("sortie_lieu");
                        oLieux.innerHTML = optionLieu;
                    }
                )
                .catch(
                    (e) => { console.log(e.toString()); }
                );
        }else{
            let optionLieu = "<option value=''>-- Sélectionnez une ville au dessus --</option>\n";
            let selectLieux = document.getElementById("sortie_lieu");
            selectLieux.innerHTML = optionLieu;
        }
        }


