</script>
<div id="events-form-wrapper">
    <form action="" class="form">
        <div class="form-group">
            <div class="row">
                <div class="col-md-5 col-sm-6 col-xs-12 col-lg-5">
                    <label for="event" class="col-sm-3">Select Event</label>
                    <div class="col-sm-9">
                        <select name="event" class="form-control" id="event-selected">
                            <?php /*foreach ($events as $key => $value) {
                                echo '<option data-max='.$value['max'].' data-min='.$value['min'].' value='.$value['eventid'].'>'.ucwords($value['ename']).'</option>
                            </br>';
                        }*/ ?> 
                        <option data-max="3" data-min="1" value="46">Aakanksha</option>
                        <option data-max="4" data-min="2" value="33">Aerial Tramline</option>
                        <option data-max="3" data-min="2" value="65">Aerogami</option>
                        <option data-max="1" data-min="1" value="12">Algolympics</option>
                        <option data-max="2" data-min="1" value="70">Amusing Math </option> 
                        <option data-max="3" data-min="2" value="59">Aquafrost</option>
                        <option data-max="5" data-min="2" value="14">Arm Rover</option>
                        <option data-max="5" data-min="2" value="5">Avion E (Spotlight)</option>
                        <option data-max="1" data-min="1" value="24">Biomazes</option>
                        <option data-max="3" data-min="1" value="37">Biomimicry</option>
                        <option data-max="3" data-min="1" value="23">Chemstorm</option>
                        <option data-max="4" data-min="1" value="60">Chemswitch</option>
                        <option data-max="3" data-min="2" value="50">Chemtransit</option>
                        <option data-max="3" data-min="2" value="6">Circuitrix</option>
                        <option data-max="5" data-min="2" value="29">Coil Gun</option>
                        <option data-max="4" data-min="2" value="22">Concreting Concrete</option>
                        <option data-max="1" data-min="1" value="30">Cryptex</option>
                        <option data-max="3" data-min="2" value="25">Dark Perception</option>
                        <option data-max="4" data-min="2" value="62">Electrocution</option>
                        <option data-max="2" data-min="1" value="7">Electronic Debugging</option>
                        <option data-max="3" data-min="2" value="68">Etch Itt</option>
                        <option data-max="4" data-min="2" value="43">Exergy</option>
                        <option data-max="3" data-min="2" value="13">Formula-E</option>
                        <option data-max="4" data-min="2" value="54">Fox Hunt</option>
                        <option data-max="4" data-min="3" value="41">Hassle Free City</option>
                        <option data-max="5" data-min="2" value="4">Hovermania (Spotlight)</option>
                        <option data-max="5" data-min="3" value="28">I Engineer</option>
                        <option data-max="3" data-min="2" value="56">Idea to Imapact</option>
                        <option data-max="3" data-min="1" value="69">Indian Ancient Tanks</option>
                        <option data-max="3" data-min="1" value="61">Illuminate</option>
                        <option data-max="5" data-min="2" value="1">Jahaaz (Spotlight)</option>
                        <option data-max="5" data-min="2" value="26">Junkyard Wars</option>
                        <option data-max="3" data-min="2" value="11">Kode-Kraft</option>
                        <option data-max="3" data-min="2" value="35">Lost Number</option>
                        <option data-max="3" data-min="1" value="31">Lumos</option>
                        <option data-max="2" data-min="1" value="21">M-cad</option>
                        <option data-max="4" data-min="2" value="51">Maglev</option>
                        <option data-max="3" data-min="2" value="42">Metal Tracking</option>
                        <option data-max="3" data-min="1" value="17">Mouse Trap Racer</option>
                        <option data-max="5" data-min="2" value="3">National Robotic Championship (Spotlight)</option>
                        <option data-max="3" data-min="1" value="27">Paper Presentation</option>
                        <option data-max="5" data-min="3" value="64">Product Launch</option>
                        <option data-max="4" data-min="3" value="63">Ponder Crack</option>
                        <option data-max="5" data-min="2" value="18">Robo Cricket</option>
                        <option data-max="4" data-min="2" value="19">Robo Golf</option>
                        <option data-max="4" data-min="2" value="39">Robo Shooter</option>
                        <option data-max="4" data-min="1" value="16">Rover</option>
                        <option data-max="2" data-min="2" value="49">TechFresh</option>
                        <option data-max="1" data-min="1" value="72">Technoshot</option>
                        <option data-max="1" data-min="1" value="10">Test Your Wits</option>
                        <option data-max="3" data-min="2" value="20">Thrust</option>
                        <option data-max="3" data-min="2" value="38">Track The Past</option>
                        <option data-max="3" data-min="2" value="32">Witricity</option>
                        <option data-max="5" data-min="2" value="2">Wreckage (Spotlight)</option>
                        <option data-max="3" data-min="1" value="48">Zodiac</option>                  
                    </select>
                </div>
            </div>
            <div class="clearfix visible-xs">
                <br>    
            </div>
            <div class="col-md-6 col-xs-12 col-sm-6 col-lg-6">
                <div class="col-sm-3">
                    <label for="event-details">Events Details</label>
                </div>
                <div class="col-sm-9">
                    <p id="event-details">
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="well">
            <h4>Instructions to register for Events</h4>
            <small> 
                <ul> 
                    <li>All the team members should make an Technozion account on ( <a href="http://technozion.in">register.technozion.org</a> )</li>
                    <li>All the team members should pay registrations fees (400 INR) and Hospitality fees (600 INR) if required from their respective Technozion Accounts</li>
                    <li>One participant can register for any number of events</li>
                    <li>All the team members should pay the amount to confirm the registration</li>
                    <li>Only Technozion Id is required for adding team members</li>
                </ul>
            </small>
        </div>
    </div>
    <div class="form-group">
        <div class="alert" id="participant-status">
        </div>
        <table class="table table-condensed col-sm-12" id="participants">
            <thead>
                <tr>
                    <th class="hidden-xs"><span class="visible-xs"><small> # </small></span><span class="hidden-xs">Sr. No.</span></th>
                    <th><span class="visible-xs"><small> TZ Id   </small></span><span class="hidden-xs">Technozion Id</span></th>
                    <th>Name</th>
                    <th class="hidden-xs">College</th>
                    <th class="hidden-xs">Roll Number</th>
                    <th> </th>
                </tr>
            </thead>
            <tbody>
                <tr class="participant">
                    <td class="hidden-xs"><span>1.</span></td>
                    <td>
                        <input class="participant-id form-control input-sm" data-valid="true" type="text" disabled value="<?php echo $selfDetails->userid; ?>">
                    </td>
                    <td>
                        <input class="participant-name form-control input-sm" type="text" disabled value="<?php echo $selfDetails->name; ?>">
                    </td>
                    <td class="hidden-xs">
                        <input class="participant-college form-control input-sm" type="text" disabled value="<?php echo $selfDetails->college; ?>">
                    </td>
                    <td class="hidden-xs">
                        <input class="participant-collegeid form-control input-sm" type="text" disabled value="<?php echo $selfDetails->collegeid; ?>">
                    </td>
                    <td>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="col-sm-3 col-sm-offset-9">
            <button class="btn btn-primary btn-block btn-sm" id="add-teammate"><span class="glyphicon glyphicon-plus"></span> Add more team members1</button>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-4 col-xs-12">
            <button class="btn btn-primary btn-block btn-lg" id="register-team">
                REGISTER EVENT1
            </button>
        </div> 
    </div>
</form>
</div>
