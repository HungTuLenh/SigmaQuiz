import { Link } from 'react-router-dom';

const Home = () => {
    return (
        <div className="app-container">
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

export default Home;
