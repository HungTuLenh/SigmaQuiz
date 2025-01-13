import Button from 'react-bootstrap/esm/Button';
const HomePage = () => {
    return (
        <div className="homepage-container">
            <img
                className="image-homepage"
                src={require('../../assets/image-homepage.jpg')}
                alt=""
            />
            <div className="homepage-content">
                <img src={require('../../assets/logo-homepage.png')} alt="" />
                <div className="description">
                    Tạo bài kiểm tra nhanh chóng cùng Sigma Quiz
                </div>
                <Button className="signup" variant="dark">
                    Đăng ký miễn phí
                </Button>
            </div>
        </div>
    );
};

export default HomePage;
