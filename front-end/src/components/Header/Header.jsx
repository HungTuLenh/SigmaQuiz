import Container from 'react-bootstrap/Container';
import Nav from 'react-bootstrap/Nav';
import Navbar from 'react-bootstrap/Navbar';
import NavDropdown from 'react-bootstrap/NavDropdown';
import { Link } from 'react-router-dom';

const Header = () => {
    return (
        <Navbar expand="lg" className="bg-body-tertiary">
            <Container>
                <Link to="/" className="navbar-brand">
                    Sigma Quiz
                </Link>
                <Navbar.Toggle aria-controls="basic-navbar-nav" />
                <Navbar.Collapse id="basic-navbar-nav">
                    <Nav className="me-auto">
                        <Link to="/home" className="nav-link">
                            Home
                        </Link>
                        <Link to="/admins" className="nav-link">
                            Admin
                        </Link>
                        <Link to="/users" className="nav-link">
                            User
                        </Link>
                    </Nav>

                    <Nav>
                        <NavDropdown title="Setting" id="basic-nav-dropdown">
                            <NavDropdown.Item href="#action/3.1">
                                Login
                            </NavDropdown.Item>
                            <NavDropdown.Item href="#action/3.2">
                                Logout
                            </NavDropdown.Item>
                            <NavDropdown.Item href="#action/3.3">
                                Profile
                            </NavDropdown.Item>
                            <NavDropdown.Divider />
                            <NavDropdown.Item href="#action/3.4">
                                Separated link
                            </NavDropdown.Item>
                        </NavDropdown>
                    </Nav>
                </Navbar.Collapse>
            </Container>
        </Navbar>
    );
};

export default Header;
