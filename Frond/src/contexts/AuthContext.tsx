import React, { createContext, useContext, useState, useEffect, ReactNode } from 'react';
import { User } from '@/types/car';
import { authService } from '@/services/authService';
import { toast } from 'sonner';

interface AuthContextType {
  user: User | null;
  isAuthenticated: boolean;
  login: (email: string, password: string) => Promise<boolean>;
  register: (name: string, phone: string, email: string, password: string) => Promise<boolean>;
  logout: () => void;
  showAuthModal: boolean;
  setShowAuthModal: (show: boolean) => void;
}

const AuthContext = createContext<AuthContextType | undefined>(undefined);

export function AuthProvider({ children }: { children: ReactNode }) {
  const [user, setUser] = useState<User | null>(null);
  const [showAuthModal, setShowAuthModal] = useState(false);

  // Load user from localStorage on mount
  useEffect(() => {
    const storedUser = localStorage.getItem('user');
    const token = localStorage.getItem('auth_token');
    if (storedUser && token) {
      setUser(JSON.parse(storedUser));
    }
  }, []);

  const login = async (email: string, password: string): Promise<boolean> => {
    try {
      const response = await authService.login({ email, password });
      localStorage.setItem('auth_token', response.access_token);
      localStorage.setItem('user', JSON.stringify(response.user));
      setUser(response.user);
      toast.success('Login successful!');
      return true;
    } catch (error: any) {
      toast.error(error.response?.data?.message || 'Login failed');
      return false;
    }
  };

  const register = async (name: string, phone: string, email: string, password: string): Promise<boolean> => {
    try {
      const response = await authService.register({
        name,
        email,
        password,
        password_confirmation: password,
        phone,
      });
      localStorage.setItem('auth_token', response.access_token);
      localStorage.setItem('user', JSON.stringify(response.user));
      setUser(response.user);
      toast.success('Registration successful!');
      return true;
    } catch (error: any) {
      toast.error(error.response?.data?.message || 'Registration failed');
      return false;
    }
  };

  const logout = async () => {
    try {
      await authService.logout();
    } catch (error) {
      console.error('Logout error:', error);
    } finally {
      // Always clear local data
      localStorage.removeItem('auth_token');
      localStorage.removeItem('user');
      setUser(null);
      toast.success('Logged out successfully');
    }
  };

  return (
    <AuthContext.Provider
      value={{
        user,
        isAuthenticated: !!user,
        login,
        register,
        logout,
        showAuthModal,
        setShowAuthModal,
      }}
    >
      {children}
    </AuthContext.Provider>
  );
}

export function useAuth() {
  const context = useContext(AuthContext);
  if (context === undefined) {
    throw new Error('useAuth must be used within an AuthProvider');
  }
  return context;
}
