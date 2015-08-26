<?php

  $form["redirect_to_if_error"] = path("new", "game");
  $form["destination_path"] = path("create", "game");
  $form["html_form_path"] = VIEW_PATH."game/new_form.php";

  foreach (select_suspects() as $suspect) {
    $form["fields"]["cards_suspect_".$suspect["id"]] = create_quantity_field("le nombre de cartes de ".pretty_suspect($suspect["id"]), total_card_number);
  }
  $form["fields"]["known_cards"] = create_id_field("mes cartes", "card", array("multiple" => 1));
  $form["fields"]["identity"] = create_id_field("mon identité", "card");

  function check_total_card_number($input) {
    $sum = 0;
    foreach ($input as $name => $value) {
      if (substr($name, 0, 14) == "cards_suspect_") {
        $sum += $value;
      }
    }
    if ($sum != total_card_number) {
      return "La somme des cartes ne fait pas ".total_card_number.".";
    }
    return "";
  }

  function check_known_cards_matches($input) {
    if ($input["cards_suspect_".$input["fields"]["identity"]] != sizeof($input["known_cards"])) {
      return "Il faut indiquer ".$input["cards_suspect_".$input["fields"]["identity"]]." cartes connues.";
    }
    return "";
  }

  $form["validations"] = array("check_total_card_number", "check_known_cards_matches");