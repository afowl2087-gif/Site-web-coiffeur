
function afficherSection(nomSection) {
    var sections = document.getElementsByClassName("section");
    for (var i = 0; i < sections.length; i++) {
        sections[i].style.display = "none";
    }
    document.getElementById(nomSection).style.display = "block";

    if (nomSection === "clients")       chargerClients();
    if (nomSection === "services")      chargerServices();
    if (nomSection === "disponibilites") chargerDispos();
    if (nomSection === "reservations")  chargerReservations();
}



function chargerClients() {
    fetch("../assets/php/api.php?action=getClients")
    .then(function(reponse) {
        return reponse.json();
    })
    .then(function(clients) {
        var tbody = document.getElementById("tableau-clients");
        tbody.innerHTML = "";

        for (var i = 0; i < clients.length; i++) {
            var c = clients[i];
            var ligne = "<tr>";
            ligne += "<td>" + c.Id_clients + "</td>";
            ligne += "<td>" + c.civility + "</td>";
            ligne += "<td>" + c.firstname + "</td>";
            ligne += "<td>" + c.lastname + "</td>";
            ligne += "<td>" + c.email + "</td>";
            ligne += "<td>" + c.phone + "</td>";
            ligne += "<td><button class='btn-supprimer' onclick='supprimerClient(" + c.Id_clients + ")'>Supprimer</button></td>";
            ligne += "</tr>";
            tbody.innerHTML += ligne;
        }
    });
}

function ajouterClient(event) {
    event.preventDefault();

    var donnees = new FormData();
    donnees.append("prenom",    document.getElementById("client-prenom").value);
    donnees.append("nom",       document.getElementById("client-nom").value);
    donnees.append("email",     document.getElementById("client-email").value);
    donnees.append("telephone", document.getElementById("client-telephone").value);
    donnees.append("civilite",  document.getElementById("client-civilite").value);
    donnees.append("password",  document.getElementById("client-password").value);

    fetch("../assets/php/api.php?action=ajouterClient", {
        method: "POST",
        body: donnees
    })
    .then(function(reponse) {
        return reponse.json();
    })
    .then(function(resultat) {
        if (resultat.succes) {
            alert("Client ajouté !");
            document.getElementById("form-client").reset();
            chargerClients();
        } else {
            alert("Erreur : " + resultat.erreur);
        }
    });
}

function supprimerClient(id) {
    if (confirm("Supprimer ce client ?")) {
        fetch("api.php?action=supprimerClient&id=" + id)
        .then(function(reponse) {
            return reponse.json();
        })
        .then(function(resultat) {
            if (resultat.succes) {
                alert("Client supprimé !");
                chargerClients();
            }
        });
    }
}



function chargerServices() {
    fetch("../assets/php/api.php?action=getServices")
    .then(function(reponse) {
        return reponse.json();
    })
    .then(function(services) {
        var tbody = document.getElementById("tableau-services");
        tbody.innerHTML = "";

        for (var i = 0; i < services.length; i++) {
            var s = services[i];
            var ligne = "<tr>";
            ligne += "<td>" + s.Id_services + "</td>";
            ligne += "<td>" + s.name + "</td>";
            ligne += "<td>" + s.description + "</td>";
            ligne += "<td>" + s.duration_minutes + " min</td>";
            ligne += "<td>" + s.price + " €</td>";
            ligne += "<td><button class='btn-supprimer' onclick='supprimerService(" + s.Id_services + ")'>Supprimer</button></td>";
            ligne += "</tr>";
            tbody.innerHTML += ligne;
        }
    });
}

function ajouterService(event) {
    event.preventDefault();

    var donnees = new FormData();
    donnees.append("nom",         document.getElementById("service-nom").value);
    donnees.append("description", document.getElementById("service-description").value);
    donnees.append("duree",       document.getElementById("service-duree").value);
    donnees.append("prix",        document.getElementById("service-prix").value);

    fetch("../assets/php/api.php?action=ajouterService", {
        method: "POST",
        body: donnees
    })
    .then(function(reponse) {
        return reponse.json();
    })
    .then(function(resultat) {
        if (resultat.succes) {
            alert("Service ajouté !");
            document.getElementById("form-service").reset();
            chargerServices();
        } else {
            alert("Erreur : " + resultat.erreur);
        }
    });
}

function supprimerService(id) {
    if (confirm("Supprimer ce service ?")) {
        fetch("../assets/php/api.php?action=supprimerService&id=" + id)
        .then(function(reponse) {
            return reponse.json();
        })
        .then(function(resultat) {
            if (resultat.succes) {
                alert("Service supprimé !");
                chargerServices();
            }
        });
    }
}



function chargerDispos() {
    fetch("../assets/php/api.php?action=getDisponibilites")
    .then(function(reponse) {
        return reponse.json();
    })
    .then(function(dispos) {
        var tbody = document.getElementById("tableau-dispos");
        tbody.innerHTML = "";

        
        var selectDispo = document.getElementById("resa-dispo");
        selectDispo.innerHTML = "";

        for (var i = 0; i < dispos.length; i++) {
            var d = dispos[i];
            var statut = d.active == 1 ? "Disponible" : "Indisponible";
            var ligne = "<tr>";
            ligne += "<td>" + d.Id_disponibilites + "</td>";
            ligne += "<td>" + d.date_start + "</td>";
            ligne += "<td>" + statut + "</td>";
            ligne += "<td><button class='btn-supprimer' onclick='supprimerDispo(" + d.Id_disponibilites + ")'>Supprimer</button></td>";
            ligne += "</tr>";
            tbody.innerHTML += ligne;

            selectDispo.innerHTML += "<option value='" + d.Id_disponibilites + "'>" + d.date_start + "</option>";
        }
    });
}

function ajouterDispo(event) {
    event.preventDefault();

    var donnees = new FormData();
    donnees.append("date",  document.getElementById("dispo-date").value);
    donnees.append("actif", document.getElementById("dispo-actif").value);

    fetch("../assets/php/api.php?action=ajouterDisponibilite", {
        method: "POST",
        body: donnees
    })
    .then(function(reponse) {
        return reponse.json();
    })
    .then(function(resultat) {
        if (resultat.succes) {
            alert("Disponibilité ajoutée !");
            document.getElementById("form-dispo").reset();
            chargerDispos();
        } else {
            alert("Erreur : " + resultat.erreur);
        }
    });
}

function supprimerDispo(id) {
    if (confirm("Supprimer cette disponibilité ?")) {
        fetch("../assets/php/api.php?action=supprimerDisponibilite&id=" + id)
        .then(function(reponse) {
            return reponse.json();
        })
        .then(function(resultat) {
            if (resultat.succes) {
                alert("Disponibilité supprimée !");
                chargerDispos();
            }
        });
    }
}



function chargerReservations() {
   
    chargerSelectClients();
    chargerSelectServices();
    chargerDispos();

    fetch("../assets/php/api.php?action=getReservations")
    .then(function(reponse) {
        return reponse.json();
    })
    .then(function(reservations) {
        var tbody = document.getElementById("tableau-reservations");
        tbody.innerHTML = "";

        for (var i = 0; i < reservations.length; i++) {
            var r = reservations[i];
            var statutTexte = "En attente";
            if (r.status == 1) statutTexte = "Confirmée";
            if (r.status == 2) statutTexte = "Annulée";

            var ligne = "<tr>";
            ligne += "<td>" + r.Id_reservations + "</td>";
            ligne += "<td>" + r.firstname + " " + r.lastname + "</td>";
            ligne += "<td>" + r.service_name + "</td>";
            ligne += "<td>" + r.date_start + "</td>";
            ligne += "<td>" + statutTexte + "</td>";
            ligne += "<td><button class='btn-supprimer' onclick='supprimerReservation(" + r.Id_reservations + ")'>Supprimer</button></td>";
            ligne += "</tr>";
            tbody.innerHTML += ligne;
        }
    });
}

function chargerSelectClients() {
    fetch("../assets/php/api.php?action=getClients")
    .then(function(reponse) {
        return reponse.json();
    })
    .then(function(clients) {
        var select = document.getElementById("resa-client");
        select.innerHTML = "";
        for (var i = 0; i < clients.length; i++) {
            var c = clients[i];
            select.innerHTML += "<option value='" + c.Id_clients + "'>" + c.firstname + " " + c.lastname + "</option>";
        }
    });
}

function chargerSelectServices() {
    fetch("../assets/php/api.php?action=getServices")
    .then(function(reponse) {
        return reponse.json();
    })
    .then(function(services) {
        var select = document.getElementById("resa-service");
        select.innerHTML = "";
        for (var i = 0; i < services.length; i++) {
            var s = services[i];
            select.innerHTML += "<option value='" + s.Id_services + "'>" + s.name + "</option>";
        }
    });
}

function ajouterReservation(event) {
    event.preventDefault();

    var donnees = new FormData();
    donnees.append("id_client",  document.getElementById("resa-client").value);
    donnees.append("id_service", document.getElementById("resa-service").value);
    donnees.append("id_dispo",   document.getElementById("resa-dispo").value);
    donnees.append("statut",     document.getElementById("resa-statut").value);

    fetch("../assets/php/api.php?action=ajouterReservation", {
        method: "POST",
        body: donnees
    })
    .then(function(reponse) {
        return reponse.json();
    })
    .then(function(resultat) {
        if (resultat.succes) {
            alert("Réservation ajoutée !");
            chargerReservations();
        } else {
            alert("Erreur : " + resultat.erreur);
        }
    });
}

function supprimerReservation(id) {
    if (confirm("Supprimer cette réservation ?")) {
        fetch("../assets/php/api.php?action=supprimerReservation&id=" + id)
        .then(function(reponse) {
            return reponse.json();
        })
        .then(function(resultat) {
            if (resultat.succes) {
                alert("Réservation supprimée !");
                chargerReservations();
            }
        });
    }
}


chargerClients();
