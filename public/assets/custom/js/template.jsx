'use strict'

const e = React.createElement;

class TopBar extends React.Component {
    constructor(props) {
        super(props);
        this.state = {}
    }

    render() {
        return (
            <div className='fixed-navbar'>
                <div className="pull-left">
                    <button className="menu-mobile-button glyphicon glyphicon-menu-hamburger js__menu_mobile" onClick={() => setAktif(!aktif)}></button>
                    <h1 className="page-title">Perumdam TS</h1>
                </div>

                <div className="pull-right">
                    <div className="ico-item">
                        <img src={logo} alt="" className="ico-img" />
                        <ul className="sub-ico-item">
                            <li>
                                <a href="#">Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        )
    }
}

const domContainer = document.querySelector('#topbar');
ReactDOM.render(e(TopBar), domContainer);