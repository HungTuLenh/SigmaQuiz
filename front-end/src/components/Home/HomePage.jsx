import { Link } from 'react-router-dom';

const HomePage = () => {
    return (
        <div className="homepage-container">
            <div>
                <h1>Home componnets</h1>
                <div>
                    <button>
                        <Link to="/admins">Admin</Link>
                    </button>
                    <button>
                        <Link to="/users">User</Link>
                    </button>
                </div>
            </div>
        </div>
    );
};

export default HomePage;
