<?php

namespace App;

enum Situation:string
{
    case CELEBATAIRE='Célébataire';
    case DIVORCE='Divorcé(e)';
    case VEUF='Veuf(ve)';
    case MARIE='Marié(e)';
    case REMARIE='Remarié(e)';

}
