import { BrowserRouter, Route, Switch } from "react-router-dom";
import CreateEdit from "../pages/CreateEdit";
import List from "../pages/List";
import locations from "../constants/locations";
import React from "react";

function Router() {
    return (
        <div>
            <BrowserRouter>
                <div className="py-4 container">
                    <Switch>
                        <Route exact path={locations.HOME} component={List} />
                        <Route path={locations.EDIT} component={CreateEdit} />
                        <Route path={locations.CREATE} component={CreateEdit} />
                    </Switch>
                </div>
            </BrowserRouter>
        </div>
    );
}

export default Router;
